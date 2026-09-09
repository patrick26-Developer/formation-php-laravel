# Exercises — 05.3 Docker Compose: PHP + MySQL + Nginx

## Exercise 1 — Minimal stack (easy)

Write a `docker-compose.yml` with only two services: `php` (based on `php:8.3-cli`, with a volume mounting your code folder) and nothing else. Run it and check `docker compose exec php php -v`.

## Exercise 2 — Adding MySQL with persistence (easy)

Add a `mysql` service with a named volume for persistence. Start the stack, create a table via `docker compose exec mysql mysql -uroot -psecret` (or an external client), stop everything with `docker compose down` (WITHOUT `-v`), restart, and check the table still exists.

## Exercise 3 — Full PHP-FPM + Nginx + MySQL stack (medium)

Assemble the lesson's complete stack for the [Task Manager mini-project](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md): PHP-FPM, Nginx (with configuration suited to the `public/` folder), MySQL. Get the whole application working via `http://localhost:8080`.

## Exercise 4 — Environment variables (medium)

Reuse exercise 3 and extract all MySQL credentials (database name, root password) into a `.env` file, referenced in `docker-compose.yml` with `${VARIABLE}`. Check that everything still works after this change.

## Exercise 5 — Healthcheck and reliable startup order (hard)

`depends_on` alone doesn't guarantee MySQL is **ready** to accept connections, only that its container has started. Add a `healthcheck` to the `mysql` service (using `mysqladmin ping`) and a `depends_on: mysql: condition: service_healthy` condition on the `php` service, so PHP genuinely waits for MySQL to be operational before starting.

---

Compare with [solutions/](solutions/README.en.md) once done.
