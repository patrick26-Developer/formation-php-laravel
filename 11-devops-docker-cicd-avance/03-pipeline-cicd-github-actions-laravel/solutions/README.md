# Solutions — 11.3 Pipeline CI/CD complet pour Laravel

## Exercice 1

```yaml
name: CI
on: [push, pull_request]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: shivammathur/setup-php@v2
        with: { php-version: '8.3' }
      - run: composer install --prefer-dist --no-progress
      - run: cp .env.example .env
      - run: php artisan key:generate
      - run: php artisan test
```

## Exercice 2

```yaml
services:
  mysql:
    image: mysql:8
    env:
      MYSQL_DATABASE: laravel_test
      MYSQL_ROOT_PASSWORD: secret
    ports: ["3306:3306"]
    options: --health-cmd="mysqladmin ping"
steps:
  # ... étapes précédentes ...
  - run: php artisan migrate --force
    env: { DB_HOST: 127.0.0.1, DB_DATABASE: laravel_test, DB_USERNAME: root, DB_PASSWORD: secret }
  - run: php artisan test
    env: { DB_HOST: 127.0.0.1, DB_DATABASE: laravel_test, DB_USERNAME: root, DB_PASSWORD: secret }
```

## Exercice 3

```php
test('ce test échoue volontairement', function () {
    expect(1 + 1)->toBe(3);
});
```
Après `git push`, l'onglet "Actions" du dépôt affiche une croix rouge sur
le workflow, avec le détail de l'assertion échouée dans les logs. Après
correction (`toBe(2)`) et nouveau push, le workflow repasse au vert (✓).

## Exercice 4

```yaml
  - run: composer require --dev phpstan/phpstan friendsofphp/php-cs-fixer
  - name: Analyse statique
    run: vendor/bin/phpstan analyse
  - name: Style de code
    run: vendor/bin/php-cs-fixer fix --dry-run --diff
  - run: php artisan test   # placé APRÈS, ne s'exécute que si les étapes précédentes réussissent
```
Une violation de style (ex: une accolade mal placée) fait échouer l'étape
PHP-CS-Fixer, empêchant le pipeline d'atteindre l'étape des tests —
économisant du temps de calcul sur un problème détectable plus tôt.

## Exercice 5

```yaml
jobs:
  build-et-push:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - uses: docker/login-action@v3
        with:
          registry: ghcr.io
          username: ${{ github.actor }}
          password: ${{ secrets.GITHUB_TOKEN }}
      - uses: docker/build-push-action@v5
        with:
          context: .
          push: true
          tags: |
            ghcr.io/${{ github.repository }}:latest
            ghcr.io/${{ github.repository }}:${{ github.sha }}
```
Après exécution, l'onglet "Packages" du profil/dépôt GitHub liste l'image
avec ses deux tags visibles, chacun pouvant être tiré séparément :
`docker pull ghcr.io/<repo>:latest` ou `docker pull ghcr.io/<repo>:<sha>`.
