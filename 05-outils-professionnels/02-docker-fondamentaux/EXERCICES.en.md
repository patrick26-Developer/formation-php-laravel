# Exercises — 05.2 Docker: The Fundamentals

## Exercise 1 — First container (easy)

Without writing a Dockerfile, run `docker run php:8.3-cli php -v` then `docker run -it php:8.3-cli php -a` (interactive mode). Observe the difference.

## Exercise 2 — Dockerize a script (easy)

Reuse the [Calculator mini-project](../../01-php-fondamentaux/projet-mini-01-calculatrice-cli-et-web/README.en.md). Write a `Dockerfile` that packages it and runs `php src/cli.php 10 + 5` by default. Build and run the image.

## Exercise 3 — Passing arguments to a container (medium)

Modify exercise 2's `Dockerfile` to use `ENTRYPOINT` instead of `CMD`, allowing `docker run ma-calculatrice 20 / 4` with different arguments on each run.

## Exercise 4 — Dockerize a web application (medium)

Reuse the [Task Manager mini-project](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md) (its `public/` part). Write a `Dockerfile` based on `php:8.3-apache` that serves it, with a `.dockerignore` excluding `config.php` and `.git/`. Run it on port 8080.

## Exercise 5 — Optimizing image size (hard)

Compare the size of the images produced by `php:8.3-apache` (the "full" image) and `php:8.3-apache-alpine` (based on Alpine Linux, much lighter) for the same `Dockerfile`, using `docker images`. Explain in a comment the trade-off between an Alpine image (lighter) and a Debian/Ubuntu-based image (more compatible with certain PHP extensions).

---

Compare with [solutions/](solutions/README.en.md) once done.
