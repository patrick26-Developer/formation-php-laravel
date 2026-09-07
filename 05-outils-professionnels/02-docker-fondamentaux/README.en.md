# 05.2 — Docker: The Fundamentals

> **Status:** ✅ Available

## 🎯 Objectives

- Understand what a container is and how it differs from a virtual machine.
- Use the essential Docker commands.
- Write a `Dockerfile` for a simple PHP application.
- Build and run a Docker image.

## 📋 Prerequisites

[05.1 — Advanced Git](../01-git-workflow-avance-branches-pr/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### The problem Docker solves

*"It works on my machine"* is one of the most frustrating phrases in software development. Different PHP versions, missing extensions, a different operating system: all sources of inconsistency between one developer's environment, another's, and production. **Docker** packages an application together with **its entire runtime environment** (PHP version, extensions, system dependencies) into a portable, reproducible unit: a **container**.

### Container vs virtual machine

| | Virtual machine | Docker container |
|---|---|---|
| Isolation | A fully virtualized operating system | Shares the host OS kernel, isolates only processes |
| Weight | Several GB, slow startup (minutes) | A few MB to a few hundred MB, fast startup (seconds) |
| Use case | Strong isolation, different OS from the host | Packaging and deploying applications reproducibly |

### Key concepts

- **Image**: an immutable template containing the code, dependencies, and configuration needed to run — like a "frozen recipe".
- **Container**: a **running instance** of an image — like a dish prepared from the recipe.
- **`Dockerfile`**: a text file describing how to build an image, step by step.

### The essential Docker commands

```bash
docker --version                 # check the installation

docker images                     # list images downloaded/built locally
docker ps                          # list RUNNING containers
docker ps -a                        # list ALL containers (including stopped ones)

docker pull php:8.3-cli              # download an image from Docker Hub
docker run php:8.3-cli php -v          # start an ephemeral container and run a command

docker stop <id_or_name>                 # stop a running container
docker rm <id_or_name>                     # remove a stopped container
docker rmi <image>                          # remove an image
```

### Writing a first `Dockerfile`

For a simple PHP mini-project (for example, the CLI calculator from [module 01, mini-project 01](../../01-php-fondamentaux/projet-mini-01-calculatrice-cli-et-web/README.en.md)):

```dockerfile
# Dockerfile
FROM php:8.3-cli

WORKDIR /app

COPY . /app

CMD ["php", "src/cli.php"]
```

Breakdown:
- `FROM php:8.3-cli`: starts from an official image that already has PHP 8.3 installed.
- `WORKDIR /app`: sets the working folder inside the container.
- `COPY . /app`: copies the project files into the image.
- `CMD [...]`: the command run by default when a container based on this image starts.

### Building and running the image

```bash
docker build -t my-calculator .
docker run my-calculator
```

`docker build -t my-calculator .` builds an image named `my-calculator` from the `Dockerfile` in the current folder (`.`). `docker run` starts a container from it.

### A `Dockerfile` for a PHP web application

```dockerfile
FROM php:8.3-apache

COPY . /var/www/html/

EXPOSE 80
```

```bash
docker build -t my-web-app .
docker run -p 8080:80 my-web-app
```

`-p 8080:80` maps port 8080 on your machine to port 80 in the container (the one Apache listens on) — the application is then reachable at `http://localhost:8080`.

### `.dockerignore`: excluding files from the image

```
# .dockerignore
vendor/
.git/
.env
```

> 📌 Like `.gitignore` (module 00.3), `.dockerignore` avoids copying unnecessary or sensitive files into the image — notably `vendor/`, which will be cleanly reinstalled via `composer install` **inside** the image (seen in practice in [module 05.3](../03-docker-compose-php-mysql-nginx/README.md)).

## ✅ Key takeaways

- A container is a lightweight, isolated instance of an image, starting up in a few seconds.
- A `Dockerfile` describes, step by step, how to build a reproducible image.
- `docker build` builds an image, `docker run` starts a container from it.
- `-p host:container` exposes a container port on your machine.

## ➡️ Going further

- [docs.docker.com/get-started/](https://docs.docker.com/get-started/)
- [Module 05.3 — Docker Compose: PHP + MySQL + Nginx](../03-docker-compose-php-mysql-nginx/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [05.1 — Advanced Git](../01-git-workflow-avance-branches-pr/README.en.md) · **Next:** [05.3 — Docker Compose](../03-docker-compose-php-mysql-nginx/README.md) *(French only)*
