# 11.3 — Pipeline CI/CD complet avec GitHub Actions pour Laravel

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Construire un pipeline CI complet pour une application Laravel (lint, analyse statique, tests).
- Exécuter les tests Pest avec une vraie base de données dans le pipeline.
- Construire et pousser une image Docker vers un registre.
- Automatiser un déploiement (CD) déclenché par un push sur `main`.

## 📋 Prérequis

[05.4 — GitHub Actions : fondamentaux CI/CD](../../05-outils-professionnels/04-github-actions-ci-cd-fondamentaux/README.md), [11.1 — Dockerisation](../01-dockerisation-application-laravel-complete/README.md), [08.3 — Tests Pest](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md)

## ⏱️ Durée estimée

3h.

## 📖 Théorie

### De simple lint (module 05.4) à pipeline complet

Au module 05.4, votre pipeline exécutait un lint basique sur du PHP procédural. Une application Laravel réelle nécessite un pipeline avec **plusieurs étapes distinctes**, chacune pouvant faire échouer le pipeline si elle détecte un problème.

### Le pipeline CI complet

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

      - name: Installer PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          extensions: mbstring, pdo_mysql
          coverage: none

      - name: Installer les dépendances Composer
        run: composer install --prefer-dist --no-progress

      - name: Copier le fichier d'environnement
        run: cp .env.example .env

      - name: Générer la clé d'application
        run: php artisan key:generate

      - name: Analyse statique (PHPStan, module 05.5)
        run: vendor/bin/phpstan analyse

      - name: Vérifier le style de code (PHP-CS-Fixer, module 05.5)
        run: vendor/bin/php-cs-fixer fix --dry-run --diff

      - name: Exécuter les migrations
        run: php artisan migrate --force
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: laravel_test
          DB_USERNAME: root
          DB_PASSWORD: secret

      - name: Exécuter les tests Pest
        run: php artisan test
        env:
          DB_HOST: 127.0.0.1
          DB_DATABASE: laravel_test
          DB_USERNAME: root
          DB_PASSWORD: secret
```

> 💡 `services: mysql:` démarre un **vrai conteneur MySQL éphémère**, disponible uniquement pendant l'exécution de ce job — exactement le principe de `RefreshDatabase` (module 08.3) mais à l'échelle du pipeline entier : chaque exécution du CI part d'une base **totalement vierge**, garantissant que les tests ne dépendent jamais d'un état laissé par une exécution précédente.

> ⚠️ **Chaque étape qui échoue arrête le pipeline** (comportement par défaut de GitHub Actions). Une erreur PHPStan, un style de code non conforme, ou un seul test qui échoue empêche le code d'aller plus loin — c'est précisément l'objectif : ne jamais laisser passer du code qui casserait quelque chose.

### CD : construire et pousser l'image Docker

```yaml
# .github/workflows/cd.yml
name: CD

on:
  push:
    branches: [main]

jobs:
  build-et-push:
    runs-on: ubuntu-latest
    needs: []  # dans un vrai projet : needs: [qualite-et-tests] du workflow CI, via workflow_run

    steps:
      - uses: actions/checkout@v4

      - name: Connexion au registre
        uses: docker/login-action@v3
        with:
          registry: ghcr.io
          username: ${{ github.actor }}
          password: ${{ secrets.GITHUB_TOKEN }}

      - name: Construire et pousser l'image
        uses: docker/build-push-action@v5
        with:
          context: .
          push: true
          tags: ghcr.io/${{ github.repository }}:latest,ghcr.io/${{ github.repository }}:${{ github.sha }}
```

> 📌 Deux tags sont poussés : `:latest` (toujours la dernière version) **et** `:${{ github.sha }}` (le hash exact du commit) — ce second tag permet de **revenir précisément** à une version antérieure en cas de problème découvert après déploiement (rollback), impossible avec `:latest` seul qui est écrasé à chaque déploiement.

### Secrets GitHub : ne jamais coder les identifiants en dur

```yaml
env:
  DB_PASSWORD: ${{ secrets.DB_PASSWORD }}
  DEPLOY_SSH_KEY: ${{ secrets.DEPLOY_SSH_KEY }}
```

> ⚠️ Les secrets se configurent dans *Settings → Secrets and variables → Actions* du dépôt GitHub, **jamais** en clair dans le fichier YAML (qui est versionné et visible par quiconque a accès au dépôt).

## ✅ Points clés à retenir

- Un pipeline CI Laravel complet enchaîne : dépendances → analyse statique → style de code → migrations → tests, sur une base de données éphémère.
- Toute étape en échec arrête le pipeline — c'est le comportement recherché, pas un problème à contourner.
- Taguer une image Docker à la fois `:latest` et par SHA de commit permet un rollback précis.
- Les identifiants sensibles passent toujours par les secrets GitHub, jamais en clair dans le YAML.

## ➡️ Pour aller plus loin

- [docs.github.com/actions](https://docs.github.com/actions)
- [Module 11.4 — Déploiement en production](../04-deploiement-production/README.md) (suite logique du CD)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [11.2 — Environnements multiples](../02-environnements-multiples-dev-staging-prod/README.md) · **Suite :** [11.4 — Déploiement en production](../04-deploiement-production/README.md)
