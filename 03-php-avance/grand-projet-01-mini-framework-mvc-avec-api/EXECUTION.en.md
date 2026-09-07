# Execution

## Running the automated tests

```bash
./vendor/bin/phpunit
```

These tests use in-memory SQLite (see [JOURNAL.md](JOURNAL.en.md)): they run in a fraction of a second, without needing the MySQL database configured in the previous step.

## Running the application (web + API)

From the project root:

```bash
php -S localhost:8000 -t public public/index.php
```

> 📌 `-t public` sets `public/` as the server root; `public/index.php` as the second argument forces **every** request (even those matching no real file) through the front controller — essential for routes like `/taches/creer` to work.

## Using the web interface

Open `http://localhost:8000/taches`: a list of tasks with sorting (click the headers) and search. Create a task via `http://localhost:8000/taches/creer`.

## Using the JSON API

```bash
# List tasks
curl http://localhost:8000/api/taches

# Create a task
curl -X POST http://localhost:8000/api/taches \
  -H "Content-Type: application/json" \
  -d '{"titre":"Learn REST APIs","description":"Module 03.4"}'

# Retrieve a specific task
curl http://localhost:8000/api/taches/1

# Update a task (mark it as done)
curl -X PUT http://localhost:8000/api/taches/1 \
  -H "Content-Type: application/json" \
  -d '{"terminee": true}'

# Delete a task
curl -X DELETE http://localhost:8000/api/taches/1

# Test the error case: non-existent task
curl -i http://localhost:8000/api/taches/9999   # -> 404
```

## Checking Web/API consistency

Create a task via the web interface (`/taches/creer`), then immediately fetch it via `curl http://localhost:8000/api/taches`: it should appear, proving that both interfaces indeed share the same `TacheRepository` and therefore the same database.
