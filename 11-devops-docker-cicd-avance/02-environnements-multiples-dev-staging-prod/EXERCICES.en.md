# Exercises — 11.2 Multiple Environments

## Exercise 1 — Separate .env files (easy)

Create `.env.example`, `.env` (local, `APP_DEBUG=true`), and document in an `ENVIRONNEMENTS.md` the expected differences for staging and production (at minimum `APP_ENV`, `APP_DEBUG`).

## Exercise 2 — Development override (easy)

Create `docker-compose.override.yml` mounting the source code as a volume. Edit a local PHP file and verify the change is visible with no image rebuild.

## Exercise 3 — Production compose file (medium)

Create `docker-compose.prod.yml` with `restart: unless-stopped` and no code volume. Launch with `docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d` and verify that a `docker kill` on the `app` container correctly triggers its automatic restart.

## Exercise 4 — Simulating a migration deployment (medium)

On a "staging" database with test data, run `php artisan migrate --force` after adding a new migration. Verify existing data is preserved (unlike `migrate:fresh`).

## Exercise 5 — Detecting a configuration leak (hard)

With `APP_DEBUG=true` on an instance simulating production, deliberately trigger an error (division by zero, a call to a non-existent method) and observe the information exposed in the HTTP response (file paths, any SQL queries). Fix it with `APP_DEBUG=false` and compare the response (a generic error page). Document in a short report (`AUDIT.md`) what could have been exposed to an attacker.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
