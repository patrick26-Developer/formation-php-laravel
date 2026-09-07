# 11.1 — Fully Dockerizing a Laravel Application

> **Status:** ✅ Available

## 🎯 Objectives

- Build an optimized production Docker image for Laravel.
- Understand multi-stage builds.
- Orchestrate the application, database, cache, and queue worker with Docker Compose.
- Distinguish development configuration from production configuration.

## 📋 Prerequisites

[05.2 — Docker: The Fundamentals](../../05-outils-professionnels/02-docker-fondamentaux/README.en.md), [05.3 — Docker Compose: PHP + MySQL + Nginx](../../05-outils-professionnels/03-docker-compose-php-mysql-nginx/README.en.md), [Level 08 — Advanced Laravel](../../08-laravel-avance/README.en.md) (queues, module 08.1)

## ⏱️ Estimated duration

3h.

## 📖 Theory

### Recap and what changes compared to module 05.3

In module 05.3, you dockerized a simple PHP project. A complete Laravel application adds specific needs: Composer dependencies to install **inside the image**, front-end assets to compile, permissions on `storage/`, and often a **queue worker** (module 08.1) running alongside the web server.

### Multi-stage Dockerfile for Laravel

```dockerfile
# Dockerfile

# --- Stage 1: Composer dependencies ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# --- Stage 2: front-end assets (if Livewire/Vite, level 10) ---
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build

# --- Stage 3: final image, PHP + application ---
FROM php:8.3-fpm-alpine
WORKDIR /var/www/html

RUN apk add --no-cache libzip-dev libpng-dev \
    && docker-php-ext-install pdo_mysql zip gd

COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
COPY . .

RUN composer dump-autoload --optimize \
    && chown -R www-data:www-data storage bootstrap/cache

USER www-data
EXPOSE 9000
CMD ["php-fpm"]
```

> 💡 This Dockerfile has **three stages** (a multi-stage build, already seen in module 05.2): the first installs PHP dependencies, the second compiles front-end assets, the third assembles the final image **without** Composer or Node.js installed in it — only the result of their work. The production image stays as light and secure as possible (fewer installed tools = smaller attack surface).

### `docker-compose.yml` for a complete Laravel stack

```yaml
services:
  app:
    build: .
    volumes:
      - ./storage:/var/www/html/storage
    depends_on:
      - mysql
      - redis
    environment:
      DB_HOST: mysql
      CACHE_STORE: redis
      QUEUE_CONNECTION: redis

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
      MYSQL_DATABASE: laravel
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - mysql_data:/var/lib/mysql

  redis:
    image: redis:alpine

  # The queue worker (module 08.1) runs in ITS OWN container,
  # with the SAME application image, but a different command.
  queue-worker:
    build: .
    command: php artisan queue:work --tries=3
    depends_on: [app, redis]
    volumes:
      - ./storage:/var/www/html/storage

volumes:
  mysql_data:
```

> 📌 **The queue worker is a separate container**, not a process launched "on top" inside the `app` container: every Docker container should have a **single responsibility** (a principle already met in module 03.5, applied here to infrastructure). This lets you independently scale the number of workers (`docker compose up --scale queue-worker=3`) without touching the web server.

### `.dockerignore`: never copy what isn't needed

```
# .dockerignore
.git
.env
node_modules
vendor
storage/logs/*
tests
```

> ⚠️ Without `.dockerignore`, `COPY . .` would also copy `.env` (secrets, module 06.1) and `.git` (the entire repository history) into the image — a security risk if the image is later pushed to a registry, even a private one.

## ✅ Key takeaways

- A multi-stage build separates compilation (Composer, npm) from the final image, making it lighter and safer.
- Each responsibility (web server, queue worker) deserves its own container, even when they share the same application image.
- `.dockerignore` prevents secrets or unnecessary large files from being copied into the image.
- Redis often replaces MySQL/files for cache (module 08.2) and queues (module 08.1) in production, for better performance.

## ➡️ Going further

- [laravel.com/docs — Deploying Laravel](https://laravel.com/docs/deployment)
- [docs.docker.com — Multi-stage builds](https://docs.docker.com/build/building/multi-stage/)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [Level 10 — Fullstack Livewire](../../10-fullstack-laravel-livewire/README.en.md) · **Next:** [11.2 — Multiple Environments](../02-environnements-multiples-dev-staging-prod/README.en.md)
