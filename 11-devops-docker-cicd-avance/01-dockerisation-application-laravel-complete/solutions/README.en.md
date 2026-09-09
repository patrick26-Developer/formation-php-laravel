# Solutions — 11.1 Fully Dockerizing a Laravel Application

## Exercise 1

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

## Exercise 2

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

## Exercise 3

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
# Shows GenererRapportHebdomadaire Jobs being processed in real time
```

## Exercise 4

```bash
docker build -t sans-ignore .
docker run --rm sans-ignore ls -la /var/www/html
# .env, .git/ visible

# Adding .dockerignore: .git, .env, node_modules, vendor, tests
docker build -t avec-ignore .
docker run --rm avec-ignore ls -la /var/www/html
# .env and .git absent

docker images
# avec-ignore noticeably lighter (often several dozen MB less)
```

## Exercise 5

```bash
docker compose up --scale queue-worker=1  # then measure
docker compose up --scale queue-worker=3  # then measure
```
With 1 worker: 20 jobs × 2s = ~40 seconds total processing (sequential).
With 3 workers: jobs are split across the 3 processes, roughly
~14 seconds (20/3 rounded × 2s) — a nearly linear gain with the number
of workers, as long as the limiting resource (CPU, database
connections) isn't saturated first. This is the main benefit of
processing Jobs through a queue (module 08.1): processing capacity
becomes horizontally scalable, simply by adding workers.
