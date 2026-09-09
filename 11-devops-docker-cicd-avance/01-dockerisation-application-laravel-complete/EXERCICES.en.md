# Exercises — 11.1 Fully Dockerizing a Laravel Application

## Exercise 1 — Building the image (easy)

Write the lesson's multi-stage Dockerfile for the [level 06 mini-project](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.en.md) (skip the assets stage if there's no front-end build). Build the image with `docker build -t blog-laravel .`.

## Exercise 2 — Complete stack with docker-compose (easy)

Write a `docker-compose.yml` with `app`, `nginx`, `mysql`. Run `docker compose up` and access the application at `http://localhost:8000`.

## Exercise 3 — Adding Redis and a worker (medium)

Add `redis` and `queue-worker` services to the [level 08 mini-project](../../08-laravel-avance/projet-mini-05-saas-multi-utilisateurs/README.en.md)'s compose file (which already uses Jobs). Verify the worker correctly processes jobs dispatched by the application.

## Exercise 4 — .dockerignore (medium)

Build the image WITHOUT a `.dockerignore`, inspect its size (`docker images`) and content (`docker run --rm image ls -la /var/www/html`). Add a complete `.dockerignore`, rebuild, compare the size, and confirm `.env`/`.git` are no longer present.

## Exercise 5 — Scaling workers (hard)

With exercise 3's compose file, run `docker compose up --scale queue-worker=3`. Dispatch 20 jobs simulating a 2-second process each (`sleep(2)` in the Job). Measure the total processing time with 1 worker then with 3 active workers, and explain in a comment the observed gain.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
