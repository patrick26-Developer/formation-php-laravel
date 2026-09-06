# 05.3 — Docker Compose : PHP + MySQL + Nginx

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre l'intérêt de Docker Compose pour orchestrer plusieurs conteneurs.
- Écrire un `docker-compose.yml` complet : PHP-FPM, Nginx, MySQL.
- Gérer la persistance des données et les variables d'environnement.
- Lancer un environnement de développement complet en une seule commande.

## 📋 Prérequis

[05.2 — Docker : les fondamentaux](../02-docker-fondamentaux/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Pourquoi plusieurs conteneurs ?

Une application PHP réaliste a besoin d'au moins trois services : un serveur web (Nginx), un interpréteur PHP (PHP-FPM), et une base de données (MySQL). La bonne pratique Docker est **un processus principal par conteneur** — plutôt qu'un unique conteneur géant, on orchestre plusieurs conteneurs qui communiquent entre eux. **Docker Compose** décrit cette orchestration dans un seul fichier YAML.

### Anatomie d'un `docker-compose.yml`

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
      MYSQL_DATABASE: gestion_taches
      MYSQL_ROOT_PASSWORD: secret
    volumes:
      - donnees_mysql:/var/lib/mysql
    ports:
      - "3306:3306"

volumes:
  donnees_mysql:
```

Décomposition :
- **`services`** : chaque bloc (`php`, `nginx`, `mysql`) définit un conteneur.
- **`build`** vs **`image`** : `build` construit une image depuis un `Dockerfile` local ; `image` télécharge une image officielle toute prête depuis Docker Hub.
- **`volumes`** : monte un dossier de votre machine dans le conteneur. `./:/var/www/html` synchronise votre code source en temps réel — modifiez un fichier PHP localement, le conteneur le voit **immédiatement**, sans reconstruire l'image.
- **`ports`** : `"8080:80"` = port 8080 de votre machine → port 80 du conteneur.
- **`depends_on`** : définit un ordre de démarrage (mais **pas** une garantie que le service est réellement "prêt" — MySQL peut mettre quelques secondes à accepter des connexions même une fois son conteneur démarré).
- **`volumes:` (en bas, niveau racine)** : déclare un **volume nommé** (`donnees_mysql`), qui persiste les données de la base **même si le conteneur MySQL est supprimé et recréé**.

### Le `Dockerfile` pour le service PHP-FPM

```dockerfile
FROM php:8.3-fpm

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html
```

> 📌 `php:8.3-fpm` (FastCGI Process Manager) est la variante de l'image PHP conçue pour fonctionner **derrière** un serveur web comme Nginx, qui lui transmet les requêtes PHP à traiter — contrairement à `php:8.3-apache`, qui embarque son propre serveur web.

### La configuration Nginx (`docker/nginx.conf`)

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

> 📌 `fastcgi_pass php:9000` : Nginx transmet toute requête `.php` au conteneur **nommé `php`** (le nom du service dans `docker-compose.yml` sert de nom d'hôte réseau automatiquement résolu !) sur le port 9000, celui écouté par PHP-FPM.

### Les commandes essentielles de Docker Compose

```bash
docker compose up -d          # démarre TOUS les services, en arrière-plan (-d = detached)
docker compose ps               # liste les services et leur état
docker compose logs -f php        # suit les logs du service "php" en temps réel
docker compose exec php bash        # ouvre un terminal DANS le conteneur php en cours d'exécution
docker compose exec php composer install  # exécute composer install DANS le conteneur
docker compose down                   # arrête et supprime les conteneurs (les volumes nommés persistent)
docker compose down -v                  # arrête ET supprime aussi les volumes (perte des données MySQL !)
```

> ⚠️ `docker compose down -v` supprime les volumes nommés, donc **toutes les données de la base de données**. Ne l'utilisez que si vous voulez vraiment repartir de zéro.

### Variables d'environnement avec un fichier `.env`

```yaml
# docker-compose.yml
services:
  mysql:
    environment:
      MYSQL_DATABASE: ${DB_DATABASE}
      MYSQL_ROOT_PASSWORD: ${DB_PASSWORD}
```

```
# .env (jamais versionné, module 00.3)
DB_DATABASE=gestion_taches
DB_PASSWORD=secret
```

Docker Compose lit automatiquement un fichier `.env` situé dans le même dossier que `docker-compose.yml`.

## ✅ Points clés à retenir

- Un service = un conteneur = une responsabilité (règle "un processus principal par conteneur").
- Un volume monté synchronise le code source en temps réel ; un volume nommé persiste les données au-delà de la vie d'un conteneur.
- Le nom d'un service dans `docker-compose.yml` devient automatiquement un nom d'hôte résolu par les autres services (`php`, `mysql`...).
- `docker compose down -v` supprime les données persistées : à utiliser en connaissance de cause.

## ➡️ Pour aller plus loin

- [docs.docker.com/compose/](https://docs.docker.com/compose/)
- [Module 11.1 — Dockerisation complète d'une application Laravel](../../11-devops-docker-cicd-avance/01-dockerisation-application-laravel-complete/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [05.2 — Docker : les fondamentaux](../02-docker-fondamentaux/README.md) · **Suite :** [05.4 — GitHub Actions : fondamentaux CI/CD](../04-github-actions-ci-cd-fondamentaux/README.md)
