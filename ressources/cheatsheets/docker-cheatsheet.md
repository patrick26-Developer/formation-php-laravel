# Aide-mémoire Docker

## Commandes de base

```bash
docker build -t mon-image .
docker run -p 8000:80 mon-image
docker ps                      # conteneurs actifs
docker ps -a                     # tous, y compris arrêtés
docker logs -f mon-conteneur
docker exec -it mon-conteneur sh   # ouvrir un shell dans un conteneur actif
docker stop / start / rm mon-conteneur
docker images / docker rmi mon-image
```

## Docker Compose

```bash
docker compose up               # démarre tous les services
docker compose up -d              # en arrière-plan
docker compose up --build           # reconstruit les images avant de démarrer
docker compose down                   # arrête et supprime les conteneurs
docker compose logs -f app
docker compose exec app php artisan migrate
docker compose ps
```

## Dockerfile — structure type (multi-stage pour Laravel)

```dockerfile
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

FROM php:8.3-fpm-alpine
WORKDIR /var/www/html
RUN docker-php-ext-install pdo_mysql
COPY --from=vendor /app/vendor ./vendor
COPY . .
RUN composer dump-autoload --optimize
USER www-data
CMD ["php-fpm"]
```

## docker-compose.yml — squelette Laravel

```yaml
services:
  app:
    build: .
    depends_on: [mysql]
  nginx:
    image: nginx:alpine
    ports: ["8000:80"]
    volumes:
      - ./docker/nginx.conf:/etc/nginx/conf.d/default.conf
      - ./public:/var/www/html/public
  mysql:
    image: mysql:8
    environment:
      MYSQL_DATABASE: app
      MYSQL_ROOT_PASSWORD: secret
    volumes: [mysql_data:/var/lib/mysql]
volumes:
  mysql_data:
```

## .dockerignore essentiel

```
.git
.env
node_modules
vendor
tests
```

## Bonnes pratiques

- Une responsabilité par conteneur (serveur web, worker de queue, scheduler séparés).
- Toujours un `.dockerignore` (jamais de `.env`/`.git` dans l'image).
- Taguer les images par SHA de commit, pas seulement `:latest` (permet un rollback précis).

**Voir aussi :** [Niveau 05 — Outils professionnels](../../05-outils-professionnels/README.md), [Niveau 11 — DevOps avancé](../../11-devops-docker-cicd-avance/README.md)
