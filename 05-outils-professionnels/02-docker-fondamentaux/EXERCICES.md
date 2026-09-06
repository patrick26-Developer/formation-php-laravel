# Exercices — 05.2 Docker : les fondamentaux

## Exercice 1 — Premier conteneur (facile)

Sans écrire de Dockerfile, lancez `docker run php:8.3-cli php -v` puis `docker run -it php:8.3-cli php -a` (mode interactif). Observez la différence.

## Exercice 2 — Dockeriser un script (facile)

Reprenez le [mini-projet Calculatrice](../../01-php-fondamentaux/projet-mini-01-calculatrice-cli-et-web/README.md). Écrivez un `Dockerfile` qui l'empaquette et exécute `php src/cli.php 10 + 5` par défaut. Construisez et lancez l'image.

## Exercice 3 — Passer des arguments à un conteneur (moyen)

Modifiez le `Dockerfile` de l'exercice 2 pour utiliser `ENTRYPOINT` au lieu de `CMD`, permettant de faire `docker run ma-calculatrice 20 / 4` en passant des arguments différents à chaque exécution.

## Exercice 4 — Dockeriser une application web (moyen)

Reprenez le [mini-projet Gestionnaire de tâches](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md) (sa partie `public/`). Écrivez un `Dockerfile` basé sur `php:8.3-apache` qui la sert, avec un `.dockerignore` excluant `config.php` et `.git/`. Lancez-la sur le port 8080.

## Exercice 5 — Optimiser la taille de l'image (difficile)

Comparez la taille des images produites par `php:8.3-apache` (image "complète") et `php:8.3-apache-alpine` (basée sur Alpine Linux, beaucoup plus légère) pour le même `Dockerfile`, avec `docker images`. Expliquez en commentaire le compromis entre une image Alpine (plus légère) et une image basée sur Debian/Ubuntu (plus compatible avec certaines extensions PHP).

---

Comparez avec [solutions/](solutions/) une fois terminé.
