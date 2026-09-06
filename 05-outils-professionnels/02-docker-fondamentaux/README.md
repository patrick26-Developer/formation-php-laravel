# 05.2 — Docker : les fondamentaux

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre ce qu'est un conteneur et en quoi il diffère d'une machine virtuelle.
- Utiliser les commandes Docker essentielles.
- Écrire un `Dockerfile` pour une application PHP simple.
- Construire et exécuter une image Docker.

## 📋 Prérequis

[05.1 — Git avancé](../01-git-workflow-avance-branches-pr/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Le problème que Docker résout

*"Ça marche sur ma machine"* est l'une des phrases les plus frustrantes en développement logiciel. Des versions de PHP différentes, des extensions manquantes, un système d'exploitation différent : autant de sources d'incohérence entre l'environnement d'un développeur, celui d'un autre, et celui de production. **Docker** empaquette une application avec **tout son environnement d'exécution** (version de PHP, extensions, dépendances système) dans une unité portable et reproductible : un **conteneur**.

### Conteneur vs machine virtuelle

| | Machine virtuelle | Conteneur Docker |
|---|---|---|
| Isolation | Un système d'exploitation complet virtualisé | Partage le noyau de l'OS hôte, isole seulement les processus |
| Poids | Plusieurs Go, démarrage lent (minutes) | Quelques Mo à centaines de Mo, démarrage rapide (secondes) |
| Cas d'usage | Isolation forte, OS différent de l'hôte | Packager et déployer des applications de façon reproductible |

### Concepts clés

- **Image** : un modèle immuable contenant le code, les dépendances et la configuration nécessaires à l'exécution — comme une "recette figée".
- **Conteneur** : une **instance en cours d'exécution** d'une image — comme un plat préparé à partir de la recette.
- **`Dockerfile`** : un fichier texte décrivant comment construire une image, étape par étape.

### Les commandes Docker essentielles

```bash
docker --version                 # vérifier l'installation

docker images                     # lister les images téléchargées/construites localement
docker ps                          # lister les conteneurs EN COURS D'EXÉCUTION
docker ps -a                        # lister TOUS les conteneurs (y compris arrêtés)

docker pull php:8.3-cli              # télécharger une image depuis Docker Hub
docker run php:8.3-cli php -v          # lancer un conteneur éphémère et exécuter une commande

docker stop <id_ou_nom>                 # arrêter un conteneur en cours
docker rm <id_ou_nom>                     # supprimer un conteneur arrêté
docker rmi <image>                          # supprimer une image
```

### Écrire un premier `Dockerfile`

Pour un mini-projet PHP simple (par exemple la calculatrice CLI du [module 01, mini-projet 01](../../01-php-fondamentaux/projet-mini-01-calculatrice-cli-et-web/README.md)) :

```dockerfile
# Dockerfile
FROM php:8.3-cli

WORKDIR /app

COPY . /app

CMD ["php", "src/cli.php"]
```

Décomposition :
- `FROM php:8.3-cli` : part d'une image officielle contenant déjà PHP 8.3 installé.
- `WORKDIR /app` : définit le dossier de travail à l'intérieur du conteneur.
- `COPY . /app` : copie les fichiers du projet dans l'image.
- `CMD [...]` : la commande exécutée par défaut au démarrage d'un conteneur basé sur cette image.

### Construire et exécuter l'image

```bash
docker build -t ma-calculatrice .
docker run ma-calculatrice
```

`docker build -t ma-calculatrice .` construit une image nommée `ma-calculatrice` à partir du `Dockerfile` du dossier courant (`.`). `docker run` en démarre un conteneur.

### Un `Dockerfile` pour une application web PHP

```dockerfile
FROM php:8.3-apache

COPY . /var/www/html/

EXPOSE 80
```

```bash
docker build -t mon-app-web .
docker run -p 8080:80 mon-app-web
```

`-p 8080:80` fait correspondre le port 8080 de votre machine au port 80 du conteneur (celui écouté par Apache) — l'application est alors accessible sur `http://localhost:8080`.

### `.dockerignore` : exclure des fichiers de l'image

```
# .dockerignore
vendor/
.git/
.env
```

> 📌 Comme `.gitignore` (module 00.3), `.dockerignore` évite de copier des fichiers inutiles ou sensibles dans l'image — notamment `vendor/`, qui sera réinstallé proprement via `composer install` **dans** l'image (vu en pratique au [module 05.3](../03-docker-compose-php-mysql-nginx/README.md)).

## ✅ Points clés à retenir

- Un conteneur est une instance légère et isolée d'une image, démarrant en quelques secondes.
- Un `Dockerfile` décrit, étape par étape, comment construire une image reproductible.
- `docker build` construit une image, `docker run` en démarre un conteneur.
- `-p hôte:conteneur` expose un port du conteneur sur votre machine.

## ➡️ Pour aller plus loin

- [docs.docker.com/get-started/](https://docs.docker.com/get-started/)
- [Module 05.3 — Docker Compose : PHP + MySQL + Nginx](../03-docker-compose-php-mysql-nginx/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [05.1 — Git avancé](../01-git-workflow-avance-branches-pr/README.md) · **Suite :** [05.3 — Docker Compose](../03-docker-compose-php-mysql-nginx/README.md)
