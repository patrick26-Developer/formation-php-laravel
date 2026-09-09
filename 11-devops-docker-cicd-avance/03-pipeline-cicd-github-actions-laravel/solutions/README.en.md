# Solutions — 11.3 Complete CI/CD Pipeline for Laravel

## Exercise 1

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

## Exercise 2

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
  # ... previous steps ...
  - run: php artisan migrate --force
    env: { DB_HOST: 127.0.0.1, DB_DATABASE: laravel_test, DB_USERNAME: root, DB_PASSWORD: secret }
  - run: php artisan test
    env: { DB_HOST: 127.0.0.1, DB_DATABASE: laravel_test, DB_USERNAME: root, DB_PASSWORD: secret }
```

## Exercise 3

```php
test('this test deliberately fails', function () {
    expect(1 + 1)->toBe(3);
});
```
After `git push`, the repository's "Actions" tab shows a red X on the
workflow, with the failed assertion's detail in the logs. After fixing
it (`toBe(2)`) and pushing again, the workflow turns green (✓) again.

## Exercise 4

```yaml
  - run: composer require --dev phpstan/phpstan friendsofphp/php-cs-fixer
  - name: Static analysis
    run: vendor/bin/phpstan analyse
  - name: Code style
    run: vendor/bin/php-cs-fixer fix --dry-run --diff
  - run: php artisan test   # placed AFTER, only runs if previous steps succeed
```
A style violation (e.g., a misplaced brace) fails the PHP-CS-Fixer
step, preventing the pipeline from reaching the test step — saving
compute time on a problem detectable earlier.

## Exercise 5

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
After running, the GitHub profile/repository's "Packages" tab lists
the image with both tags visible, each pullable separately:
`docker pull ghcr.io/<repo>:latest` or `docker pull ghcr.io/<repo>:<sha>`.
