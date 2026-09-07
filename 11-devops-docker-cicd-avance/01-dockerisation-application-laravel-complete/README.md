# 11.1 — Dockerisation complète d'une application Laravel

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Construire une image Docker de production optimisée pour Laravel.
- Comprendre le multi-stage build.
- Orchestrer application, base de données, cache et worker de queue avec Docker Compose.
- Distinguer configuration de développement et de production.

## 📋 Prérequis

[05.2 — Docker : les fondamentaux](../../05-outils-professionnels/02-docker-fondamentaux/README.md), [05.3 — Docker Compose : PHP + MySQL + Nginx](../../05-outils-professionnels/03-docker-compose-php-mysql-nginx/README.md), [Niveau 08 — Laravel Avancé](../../08-laravel-avance/README.md) (queues, module 08.1)

## ⏱️ Durée estimée

3h.

## 📖 Théorie

### Rappel et ce qui change par rapport au module 05.3

Au module 05.3, vous avez dockerisé un projet PHP simple. Une application Laravel complète ajoute des besoins spécifiques : dépendances Composer à installer **dans l'image**, assets front-end à compiler, permissions sur `storage/`, et souvent un **worker de queue** (module 08.1) tournant en parallèle du serveur web.

### Dockerfile multi-stage pour Laravel

```dockerfile
# Dockerfile

# --- Étape 1 : dépendances Composer ---
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# --- Étape 2 : assets front-end (si Livewire/Vite, niveau 10) ---
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY resources/ resources/
COPY vite.config.js ./
RUN npm run build

# --- Étape 3 : image finale, PHP + application ---
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

> 💡 Ce Dockerfile a **trois étapes** (multi-stage build, déjà vu au module 05.2) : la première installe les dépendances PHP, la seconde compile les assets front-end, la troisième assemble l'image finale **sans** Composer ni Node.js installés dedans — seulement le résultat de leur travail. L'image de production reste ainsi la plus légère et la plus sécurisée possible (moins d'outils installés = moins de surface d'attaque).

### `docker-compose.yml` pour une stack Laravel complète

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

  # Le worker de queue (module 08.1) tourne dans SON PROPRE conteneur,
  # avec la MÊME image applicative, mais une commande différente.
  queue-worker:
    build: .
    command: php artisan queue:work --tries=3
    depends_on: [app, redis]
    volumes:
      - ./storage:/var/www/html/storage

volumes:
  mysql_data:
```

> 📌 **Le worker de queue est un conteneur séparé**, pas un processus lancé "en plus" dans le conteneur `app` : chaque conteneur Docker devrait avoir une **seule responsabilité** (principe déjà rencontré au module 03.5, appliqué ici à l'infrastructure). Cela permet de faire évoluer indépendamment le nombre de workers (`docker compose up --scale queue-worker=3`) sans toucher au serveur web.

### `.dockerignore` : ne jamais copier ce qui n'est pas nécessaire

```
# .dockerignore
.git
.env
node_modules
vendor
storage/logs/*
tests
```

> ⚠️ Sans `.dockerignore`, `COPY . .` copierait aussi `.env` (secrets, module 06.1) et `.git` (tout l'historique du dépôt) dans l'image — un risque de sécurité si l'image est ensuite poussée vers un registre, même privé.

## ✅ Points clés à retenir

- Le multi-stage build sépare la compilation (Composer, npm) de l'image finale, plus légère et plus sûre.
- Chaque responsabilité (serveur web, worker de queue) mérite son propre conteneur, même s'ils partagent la même image applicative.
- `.dockerignore` empêche de copier des secrets ou des fichiers volumineux inutiles dans l'image.
- Redis remplace souvent MySQL/fichiers pour le cache (module 08.2) et les queues (module 08.1) en production, pour de meilleures performances.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Deploying Laravel](https://laravel.com/docs/deployment)
- [docs.docker.com — Multi-stage builds](https://docs.docker.com/build/building/multi-stage/)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 10 — Fullstack Livewire](../../10-fullstack-laravel-livewire/README.md) · **Suite :** [11.2 — Environnements multiples](../02-environnements-multiples-dev-staging-prod/README.md)
