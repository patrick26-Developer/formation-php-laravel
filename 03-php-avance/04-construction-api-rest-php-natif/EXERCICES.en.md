# Exercises — 03.4 Building a REST API in Native PHP

## Exercise 1 — JSON response helpers (easy)

Create a `helpers.php` file with the lesson's `repondreJson()` and `lireCorpsJson()` functions. Write a `test.php` script that responds `{"message": "API operational"}` with status code 200.

## Exercise 2 — Creation endpoint (easy)

Simulate an in-memory PHP array (`$taches = [];`) as the "database". Create an endpoint that reads a JSON body `{"titre": "..."}`, validates that `titre` is present (otherwise 400), adds the task to the array with an auto-incremented ID, and responds 201 with the created task.

## Exercise 3 — List endpoint with status codes (medium)

Create an endpoint that returns the full list of tasks with 200, but if the array is empty, still responds 200 with an empty array (not an error — an empty list is a **valid** result, not an error).

## Exercise 4 — Endpoint with full error handling (medium)

Create a `GET /taches/{id}` endpoint (simulate `$id` via `$_GET['id']`) that responds 404 if the ID doesn't exist in the array, and 200 with the task otherwise. Add a simulated `DELETE` endpoint (check `$_SERVER['REQUEST_METHOD']`) that responds 204 with no content if the deletion succeeds, 404 otherwise.

## Exercise 5 — Complete mini CRUD API (hard)

Assemble all the previous exercises into a single mini-API with a simple router (reuse the one from [module 03.2](../02-architecture-mvc-from-scratch/README.en.md)) handling: `GET /api/taches`, `POST /api/taches`, `GET /api/taches/{id}`, `DELETE /api/taches/{id}`. Test each endpoint with `curl` (include example commands in a comment).

---

Compare with [solutions/](solutions/README.en.md) once done.
