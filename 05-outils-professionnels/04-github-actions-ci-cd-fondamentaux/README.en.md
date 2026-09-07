# 05.4 — GitHub Actions: CI/CD Fundamentals

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the concepts of Continuous Integration (CI) and Continuous Deployment (CD).
- Write a first GitHub Actions workflow.
- Automatically run PHPUnit tests on every push.
- Add code style checking to the pipeline.

## 📋 Prerequisites

[05.1 — Advanced Git](../01-git-workflow-avance-branches-pr/README.en.md) and [03.3 — Unit Testing with PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### CI/CD: what are we talking about?

- **CI (Continuous Integration)**: on every code change pushed to the repository, a suite of automatic steps checks that nothing is broken (tests, style checks, static analysis).
- **CD (Continuous Deployment/Delivery)**: automates deployment to production (or a test environment) once CI passes successfully. Covered in depth in [module 11.3](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md).

The main benefit: detecting a problem **immediately**, before it reaches the main branch or production — rather than discovering a bug days later.

### Anatomy of a GitHub Actions workflow

A workflow is a YAML file placed in `.github/workflows/`.

```yaml
# .github/workflows/tests.yml
name: Tests

on:
  push:
    branches: [main]
  pull_request:
    branches: [main]

jobs:
  tests:
    runs-on: ubuntu-latest

    steps:
      - name: Check out the code
        uses: actions/checkout@v4

      - name: Install PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'

      - name: Install Composer dependencies
        run: composer install --prefer-dist --no-progress

      - name: Run PHPUnit tests
        run: ./vendor/bin/phpunit
```

Breakdown:
- **`on`**: the events that trigger the workflow (`push`, `pull_request`, on the `main` branch).
- **`jobs`**: one or more jobs, each running on a fresh virtual machine (`runs-on: ubuntu-latest`).
- **`steps`**: the sequential steps of a job. `uses` runs a reusable community-published **action**; `run` runs a plain shell command.

### Applying this workflow to the level 03 large project

For the [MVC Mini-Framework with API large project](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.en.md), this workflow would work almost as-is — its tests use in-memory SQLite (module 03.2), so **no additional database service is needed** in the pipeline.

### Adding a MySQL database to the pipeline (when tests need one)

```yaml
jobs:
  tests:
    runs-on: ubuntu-latest

    services:
      mysql:
        image: mysql:8.0
        env:
          MYSQL_DATABASE: test_db
          MYSQL_ROOT_PASSWORD: secret
        ports:
          - 3306:3306
        options: --health-cmd="mysqladmin ping" --health-interval=5s --health-retries=10

    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - run: composer install
      - run: ./vendor/bin/phpunit
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: test_db
          DB_PASSWORD: secret
```

> 📌 `services:` in a GitHub Actions workflow works like a simplified `docker-compose.yml` (module 05.3): a MySQL container is started **just for the duration of the job**, with its own `healthcheck`.

### Adding style checking and static analysis

```yaml
      - name: Check PSR-12 style
        run: ./vendor/bin/php-cs-fixer fix --dry-run --diff

      - name: Static analysis with PHPStan
        run: ./vendor/bin/phpstan analyse src
```

> 📌 `--dry-run` on PHP-CS-Fixer: flags non-compliant files **without modifying them**, and fails the job if corrections would be needed — appropriate in CI (you don't want CI to silently modify code). Covered in depth in [module 05.5](../05-qualite-code-phpstan-php-cs-fixer/README.md).

### Status badge in the README

Once the workflow is in place, GitHub lets you display a badge in the repository's `README.md`:

```markdown
![Tests](https://github.com/your-username/your-repo/actions/workflows/tests.yml/badge.svg)
```

## ✅ Key takeaways

- A workflow reacts to events (`push`, `pull_request`) and runs jobs on ephemeral virtual machines.
- `services:` in a workflow lets you start a temporary database for tests, with no manual configuration.
- Failing CI on non-compliant code style (`--dry-run`) avoids having to discuss it in human code review.
- CI should pass **before** merging a Pull Request — configurable as a mandatory rule on GitHub (branch protection).

## ➡️ Going further

- [docs.github.com/actions](https://docs.github.com/actions)
- [Module 11.3 — Complete CI/CD Pipeline with GitHub Actions for Laravel](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [05.3 — Docker Compose](../03-docker-compose-php-mysql-nginx/README.en.md) · **Next:** [05.5 — Code Quality: PHPStan and PHP-CS-Fixer](../05-qualite-code-phpstan-php-cs-fixer/README.en.md)
