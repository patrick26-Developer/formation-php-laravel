# Solutions — 11.1 Dockerisation complète d'une application Laravel

## Exercice 1

```dockerfile
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

FROM php:8.3-fpm-alpine
WORKDIR /var/www/html
RUN docker-php-ext-install pdo_mysql
COPY --from=vendor /app/vendor ./vendor
COPY . .
RUN composer dump-autoload --optimize && chown -R www-data:www-data storage bootstrap/cache
USER www-data
CMD ["php-fpm"]
```
```bash
docker build -t blog-laravel .
```

## Exercice 2

```yaml
services:
  app:
    build: .
    depends_on: [mysql]
    environment:
      DB_HOST: mysql
  nginx:
    image: nginx:alpine
    ports: ["8000:80"]
    volumes:
      - ./docker/nginx.conf:/etc/nginx/conf.d/default.conf
      - ./public:/var/www/html/public
    depends_on: [app]
  mysql:
    image: mysql:8
    environment:
      MYSQL_DATABASE: blog
      MYSQL_ROOT_PASSWORD: secret
```
```bash
docker compose up
```

## Exercice 3

```yaml
  redis:
    image: redis:alpine

  queue-worker:
    build: .
    command: php artisan queue:work --tries=3
    depends_on: [app, redis]
    environment:
      QUEUE_CONNECTION: redis
```
```bash
docker compose logs -f queue-worker
# Affiche le traitement des Jobs GenererRapportHebdomadaire au fur et à mesure
```

## Exercice 4

```bash
docker build -t sans-ignore .
docker run --rm sans-ignore ls -la /var/www/html
# .env, .git/ visibles

# Ajout de .dockerignore : .git, .env, node_modules, vendor, tests
docker build -t avec-ignore .
docker run --rm avec-ignore ls -la /var/www/html
# .env et .git absents

docker images
# avec-ignore nettement plus légère (souvent plusieurs dizaines de Mo de moins)
```

## Exercice 5

```bash
docker compose up --scale queue-worker=1  # puis mesurer
docker compose up --scale queue-worker=3  # puis mesurer
```
Avec 1 worker : 20 jobs × 2s = ~40 secondes de traitement total (séquentiel).
Avec 3 workers : les jobs se répartissent entre les 3 processus, environ
~14 secondes (20/3 arrondi × 2s) — un gain quasi linéaire avec le nombre
de workers, tant que la ressource limitante (CPU, connexions base de
données) n'est pas saturée avant. C'est l'intérêt principal de traiter les
Jobs via une file d'attente (module 08.1) : la capacité de traitement
devient horizontalement scalable, simplement en ajoutant des workers.
