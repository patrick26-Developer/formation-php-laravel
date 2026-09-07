# 05.3 — Docker Compose: PHP + MySQL + Nginx

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the value of Docker Compose for orchestrating several containers.
- Write a complete `docker-compose.yml`: PHP-FPM, Nginx, MySQL.
- Manage data persistence and environment variables.
- Launch a complete development environment with a single command.

## 📋 Prerequisites

[05.2 — Docker: The Fundamentals](../02-docker-fondamentaux/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Why several containers?

A realistic PHP application needs at least three services: a web server (Nginx), a PHP interpreter (PHP-FPM), and a database (MySQL). Good Docker practice is **one main process per container** — rather than a single giant container, you orchestrate several containers that communicate with each other. **Docker Compose** describes this orchestration in a single YAML file.

### Anatomy of a `docker-compose.yml`

```yaml
services:
  php:
    build:
      context: .
      dockerfile: Dockerfile
    volumes:
      - ./:/var/www/html
    depends_on:
      - mysql

  nginx:
    image: nginx:alpine
    ports:
      - "8080:80"
    volumes:
      - ./:/var/www/html
      - ./docker/nginx.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - php

  mysql:
    image: mysql:8.0
    environment:
      MYSQL_DATABASE: task_manager
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - mysql_data:/var/lib/mysql
    ports:
      - "3306:3306"

volumes:
  mysql_data:
```

Breakdown:
- **`services`**: each block (`php`, `nginx`, `mysql`) defines a container.
- **`build`** vs **`image`**: `build` builds an image from a local `Dockerfile`; `image` downloads a ready-made official image from Docker Hub.
- **`volumes`**: mounts a folder from your machine into the container. `./:/var/www/html` syncs your source code in real time — edit a PHP file locally, the container sees it **immediately**, without rebuilding the image.
- **`ports`**: `"8080:80"` = port 8080 on your machine → port 80 in the container.
- **`depends_on`**: sets a startup order (but **not** a guarantee that the service is actually "ready" — MySQL can take a few seconds to accept connections even once its container has started).
- **`volumes:` (at the bottom, root level)**: declares a **named volume** (`mysql_data`), which persists the database's data **even if the MySQL container is removed and recreated**.

### The `Dockerfile` for the PHP-FPM service

```dockerfile
FROM php:8.3-fpm

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html
```

> 📌 `php:8.3-fpm` (FastCGI Process Manager) is the PHP image variant designed to run **behind** a web server like Nginx, which forwards PHP requests to it for processing — unlike `php:8.3-apache`, which bundles its own web server.

### The Nginx configuration (`docker/nginx.conf`)

```nginx
server {
    listen 80;
    root /var/www/html/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass php:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

> 📌 `fastcgi_pass php:9000`: Nginx forwards every `.php` request to the container **named `php`** (the service name in `docker-compose.yml` automatically serves as a resolvable network hostname!) on port 9000, the one PHP-FPM listens on.

### The essential Docker Compose commands

```bash
docker compose up -d          # starts ALL services, in the background (-d = detached)
docker compose ps               # lists services and their state
docker compose logs -f php        # follows the "php" service's logs in real time
docker compose exec php bash        # opens a terminal INSIDE the running php container
docker compose exec php composer install  # runs composer install INSIDE the container
docker compose down                   # stops and removes the containers (named volumes persist)
docker compose down -v                  # stops AND also removes the volumes (MySQL data lost!)
```

> ⚠️ `docker compose down -v` removes named volumes, meaning **all database data**. Only use it if you genuinely want to start from scratch.

### Environment variables with a `.env` file

```yaml
# docker-compose.yml
services:
  mysql:
    environment:
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
```

```
# .env (never version-controlled, module 00.3)
DB_DATABASE=task_manager
DB_PASSWORD=secret
```

Docker Compose automatically reads a `.env` file located in the same folder as `docker-compose.yml`.

## ✅ Key takeaways

- One service = one container = one responsibility ("one main process per container" rule).
- A mounted volume syncs source code in real time; a named volume persists data beyond a container's lifetime.
- A service's name in `docker-compose.yml` automatically becomes a hostname resolved by the other services (`php`, `mysql`...).
- `docker compose down -v` deletes persisted data: use it knowingly.

## ➡️ Going further

- [docs.docker.com/compose/](https://docs.docker.com/compose/)
- [Module 11.1 — Fully Dockerizing a Laravel Application](../../11-devops-docker-cicd-avance/01-dockerisation-application-laravel-complete/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [05.2 — Docker: The Fundamentals](../02-docker-fondamentaux/README.en.md) · **Next:** [05.4 — GitHub Actions: CI/CD Fundamentals](../04-github-actions-ci-cd-fondamentaux/README.en.md)
