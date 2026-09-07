# 11.3 — Complete CI/CD Pipeline with GitHub Actions for Laravel

> **Status:** ✅ Available

## 🎯 Objectives

- Build a complete CI pipeline for a Laravel application (lint, static analysis, tests).
- Run Pest tests against a real database within the pipeline.
- Build and push a Docker image to a registry.
- Automate a deployment (CD) triggered by a push to `main`.

## 📋 Prerequisites

[05.4 — GitHub Actions: CI/CD Fundamentals](../../05-outils-professionnels/04-github-actions-ci-cd-fondamentaux/README.en.md), [11.1 — Dockerization](../01-dockerisation-application-laravel-complete/README.en.md), [08.3 — Pest Tests](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.en.md)

## ⏱️ Estimated duration

3h.

## 📖 Theory

### From simple lint (module 05.4) to a complete pipeline

In module 05.4, your pipeline ran a basic lint on procedural PHP. A real Laravel application needs a pipeline with **several distinct steps**, each able to fail the pipeline if it detects a problem.

### The complete CI pipeline

```yaml
# .github/workflows/ci.yml
name: CI

on:
  push:
    branches: [main, develop]
  pull_request:
    branches: [main]

jobs:
  qualite-et-tests:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8
        env:
          MYSQL_DATABASE: laravel_test
          MYSQL_ROOT_PASSWORD: secret
        ports: ["3306:3306"]
        options: --health-cmd="mysqladmin ping" --health-interval=10s --health-timeout=5s --health-retries=5

    steps:
      - uses: actions/checkout@v4

      - name: Install PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: mbstring, pdo_mysql
          coverage: none

      - name: Install Composer dependencies
        run: composer install --prefer-dist --no-progress

      - name: Copy the environment file
        run: cp .env.example .env

      - name: Generate the application key
        run: php artisan key:generate

      - name: Static analysis (PHPStan, module 05.5)
        run: vendor/bin/phpstan analyse

      - name: Check code style (PHP-CS-Fixer, module 05.5)
        run: vendor/bin/php-cs-fixer fix --dry-run --diff

      - name: Run migrations
        run: php artisan migrate --force
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: laravel_test
          DB_USERNAME: root
          DB_PASSWORD: secret

      - name: Run Pest tests
        run: php artisan test
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: laravel_test
          DB_USERNAME: root
          DB_PASSWORD: secret
```

> 💡 `services: mysql:` starts a **real, ephemeral MySQL container**, available only for the duration of this job — exactly the same principle as `RefreshDatabase` (module 08.3) but applied to the whole pipeline: every CI run starts from a **completely blank** database, guaranteeing that tests never depend on state left over from a previous run.

> ⚠️ **Any step that fails stops the pipeline** (GitHub Actions' default behavior). A PHPStan error, non-compliant code style, or even a single failing test prevents the code from going any further — this is precisely the goal: never let through code that would break something.

### CD: building and pushing the Docker image

```yaml
# .github/workflows/cd.yml
name: CD

on:
  push:
    branches: [main]

jobs:
  build-et-push:
    runs-on: ubuntu-latest
    needs: []  # in a real project: needs: [qualite-et-tests] from the CI workflow, via workflow_run

    steps:
      - uses: actions/checkout@v4

      - name: Log in to the registry
        uses: docker/login-action@v3
        with:
          registry: ghcr.io
          username: ${{ github.actor }}
          password: ${{ secrets.GITHUB_TOKEN }}

      - name: Build and push the image
        uses: docker/build-push-action@v5
        with:
          context: .
          push: true
          tags: ghcr.io/${{ github.repository }}:latest,ghcr.io/${{ github.repository }}:${{ github.sha }}
```

> 📌 Two tags are pushed: `:latest` (always the newest version) **and** `:${{ github.sha }}` (the exact commit hash) — this second tag lets you **precisely roll back** to an earlier version if a problem is discovered after deployment, impossible with `:latest` alone, which gets overwritten on every deployment.

### GitHub secrets: never hardcode credentials

```yaml
env:
  DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
  DEPLOY_SSH_KEY: ${{ secrets.DEPLOY_SSH_KEY }}
```

> ⚠️ Secrets are configured in the GitHub repository's *Settings → Secrets and variables → Actions*, **never** in plaintext in the YAML file (which is version-controlled and visible to anyone with access to the repository).

## ✅ Key takeaways

- A complete Laravel CI pipeline chains: dependencies → static analysis → code style → migrations → tests, against an ephemeral database.
- Any failing step stops the pipeline — this is the intended behavior, not a problem to work around.
- Tagging a Docker image both `:latest` and by commit SHA enables a precise rollback.
- Sensitive credentials always go through GitHub secrets, never in plaintext in the YAML.

## ➡️ Going further

- [docs.github.com/actions](https://docs.github.com/actions)
- [Module 11.4 — Production Deployment](../04-deploiement-production/README.en.md) (the logical continuation of CD)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [11.2 — Multiple Environments](../02-environnements-multiples-dev-staging-prod/README.en.md) · **Next:** [11.4 — Production Deployment](../04-deploiement-production/README.en.md)
