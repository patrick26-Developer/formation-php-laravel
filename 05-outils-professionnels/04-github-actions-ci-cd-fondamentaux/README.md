# 05.4 — GitHub Actions : fondamentaux CI/CD

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre les concepts d'intégration continue (CI) et de déploiement continu (CD).
- Écrire un premier workflow GitHub Actions.
- Faire exécuter automatiquement les tests PHPUnit à chaque push.
- Ajouter la vérification du style de code au pipeline.

## 📋 Prérequis

[05.1 — Git avancé](../01-git-workflow-avance-branches-pr/README.md) et [03.3 — Tests unitaires avec PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### CI/CD : de quoi parle-t-on ?

- **CI (Intégration Continue)** : à chaque modification du code poussée sur le dépôt, une suite d'étapes automatiques vérifie que rien n'est cassé (tests, analyse de style, analyse statique).
- **CD (Déploiement/Livraison Continue)** : automatise la mise en production (ou en environnement de test) une fois la CI passée avec succès. Approfondi au [module 11.3](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md).

L'intérêt principal : détecter un problème **immédiatement**, avant qu'il n'atteigne la branche principale ou la production — plutôt que de découvrir un bug des jours plus tard.

### Anatomie d'un workflow GitHub Actions

Un workflow est un fichier YAML placé dans `.github/workflows/`.

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
      - name: Récupérer le code
        uses: actions/checkout@v4

      - name: Installer PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'

      - name: Installer les dépendances Composer
        run: composer install --prefer-dist --no-progress

      - name: Lancer les tests PHPUnit
        run: ./vendor/bin/phpunit
```

Décomposition :
- **`on`** : les événements qui déclenchent le workflow (`push`, `pull_request`, sur la branche `main`).
- **`jobs`** : un ou plusieurs travaux, chacun s'exécutant sur une machine virtuelle fraîche (`runs-on: ubuntu-latest`).
- **`steps`** : les étapes séquentielles d'un job. `uses` exécute une **action** réutilisable publiée par la communauté ; `run` exécute une commande shell classique.

### Appliquer ce workflow au grand projet du niveau 03

Pour le [grand projet Mini-framework MVC avec API](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.md), ce workflow suffirait presque tel quel — ses tests utilisent SQLite en mémoire (module 03.2), donc **aucun service de base de données supplémentaire n'est nécessaire** dans le pipeline.

### Ajouter une base de données MySQL au pipeline (quand les tests en ont besoin)

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

> 📌 `services:` dans un workflow GitHub Actions fonctionne comme un `docker-compose.yml` simplifié (module 05.3) : un conteneur MySQL est démarré **juste pour la durée du job**, avec son propre `healthcheck`.

### Ajouter la vérification de style et d'analyse statique

```yaml
      - name: Vérifier le style PSR-12
        run: ./vendor/bin/php-cs-fixer fix --dry-run --diff

      - name: Analyse statique avec PHPStan
        run: ./vendor/bin/phpstan analyse src
```

> 📌 `--dry-run` sur PHP-CS-Fixer : signale les fichiers non conformes **sans les modifier**, et fait échouer le job si des corrections seraient nécessaires — approprié en CI (on ne veut pas que la CI modifie silencieusement le code). Approfondi au [module 05.5](../05-qualite-code-phpstan-php-cs-fixer/README.md).

### Badge de statut dans le README

Une fois le workflow en place, GitHub permet d'afficher un badge dans le `README.md` du dépôt :

```markdown
![Tests](https://github.com/votre-utilisateur/votre-depot/actions/workflows/tests.yml/badge.svg)
```

## ✅ Points clés à retenir

- Un workflow réagit à des événements (`push`, `pull_request`) et exécute des jobs sur des machines virtuelles éphémères.
- `services:` dans un workflow permet de démarrer une base de données temporaire pour les tests, sans configuration manuelle.
- Faire échouer la CI sur un style de code non conforme (`--dry-run`) évite d'avoir à en discuter en revue de code humaine.
- La CI doit passer **avant** de fusionner une Pull Request — configurable comme règle obligatoire sur GitHub (branch protection).

## ➡️ Pour aller plus loin

- [docs.github.com/actions](https://docs.github.com/fr/actions)
- [Module 11.3 — Pipeline CI/CD complet avec GitHub Actions pour Laravel](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [05.3 — Docker Compose](../03-docker-compose-php-mysql-nginx/README.md) · **Suite :** [05.5 — Qualité de code : PHPStan et PHP-CS-Fixer](../05-qualite-code-phpstan-php-cs-fixer/README.md)
