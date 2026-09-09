# Solutions — 11.2 Multiple Environments

## Exercise 1

```markdown
# ENVIRONNEMENTS.md

| Variable | Local | Staging | Production |
|---|---|---|---|
| APP_ENV | local | staging | production |
| APP_DEBUG | true | false | false |
| DB_DATABASE | app_local | app_staging | app_production |
| MAIL_MAILER | log | smtp (test inbox) | smtp (real) |
```

## Exercise 2

```yaml
# docker-compose.override.yml
services:
  app:
    volumes:
      - .:/var/www/html
```
After `docker compose up`, editing `routes/web.php` locally immediately
changes the served application's behavior, with no `docker build`.

## Exercise 3

```yaml
# docker-compose.prod.yml
services:
  app:
    restart: unless-stopped
```
```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
docker kill $(docker compose ps -q app)
docker compose ps  # the "app" container is already back to "Up" a few seconds later
```

## Exercise 4

```bash
php artisan make:migration add_note_moyenne_to_produits_table
# ... column added in up() ...
php artisan migrate --force
```
Existing `produits` records stay intact, only the new column appears
(the default value is applied automatically).

## Exercise 5

```markdown
# AUDIT.md

With APP_DEBUG=true: an error (e.g., DivisionByZeroError) shows the
FULL stack trace in the browser, including:
- The server files' absolute path (e.g., /var/www/html/app/...)
- The exact SQL query in progress if the error came from Eloquent
- The values of certain local variables at the time of the error
- The Laravel version and installed packages

An attacker could exploit this information to map out the
application's structure, identify vulnerable dependency versions, or
infer the database schema.

With APP_DEBUG=false: just a generic "500 | Server Error" page, with
no technical detail. The error is still logged internally
(storage/logs/laravel.log) for the technical team, but invisible to
the HTTP client.

Conclusion: APP_DEBUG=false is non-negotiable in production.
```
