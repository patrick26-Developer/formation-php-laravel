# 03.4 — Building a REST API in Native PHP

> **Status:** ✅ Available

## 🎯 Objectives

- Understand REST principles (resources, HTTP verbs, status codes).
- Build JSON endpoints in native PHP.
- Read a JSON request body and respond in the right format.
- Cleanly handle API errors.

## 📋 Prerequisites

[03.2 — MVC Architecture from Scratch](../02-architecture-mvc-from-scratch/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### What is a REST API?

An **API** (Application Programming Interface) lets programs communicate with each other, typically exchanging data in **JSON** format. **REST** (REpresentational State Transfer) is a set of conventions for organizing this communication around **resources** (entities: `users`, `tasks`...) manipulated via the standard **HTTP verbs**.

| HTTP Verb | Action | Example |
|---|---|---|
| `GET` | Read one or more resources | `GET /tasks` (list), `GET /tasks/5` (one task) |
| `POST` | Create a resource | `POST /tasks` |
| `PUT`/`PATCH` | Update a resource (fully / partially) | `PUT /tasks/5` |
| `DELETE` | Delete a resource | `DELETE /tasks/5` |

### Essential HTTP status codes

| Code | Meaning | Example use |
|---|---|---|
| `200 OK` | Success | A successful read or update |
| `201 Created` | Resource successfully created | After a successful `POST` |
| `204 No Content` | Success, no content to return | After a successful `DELETE` |
| `400 Bad Request` | Malformed request (invalid data) | A missing required field |
| `401 Unauthorized` | Authentication required or invalid | Missing or incorrect API token |
| `403 Forbidden` | Authenticated, but without the necessary rights | A user tries to modify someone else's data |
| `404 Not Found` | Non-existent resource | `GET /tasks/9999` when task 9999 doesn't exist |
| `422 Unprocessable Entity` | Data valid in format, but invalid business-wise | An email already used at sign-up |
| `500 Internal Server Error` | Unexpected server-side error | An unhandled exception |

### Responding in JSON

```php
<?php
declare(strict_types=1);

function respondJson(mixed $data, int $statusCode = 200): never {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Usage:
respondJson(['message' => 'Task created'], 201);
respondJson(['error' => 'Task not found'], 404);
```

> 📌 `JSON_UNESCAPED_UNICODE` prevents accented characters (`é`, `à`...) from being turned into unreadable `é` sequences in the JSON response.

### Reading a JSON request body

Unlike a classic HTML form, an API typically receives its request body as raw JSON, not in `$_POST`.

```php
<?php
declare(strict_types=1);

function readJsonBody(): array {
    $rawBody = file_get_contents('php://input');
    $data = json_decode($rawBody, true);

    if (!is_array($data)) {
        respondJson(['error' => 'Invalid JSON request body.'], 400);
    }

    return $data;
}
```

### A complete endpoint

```php
<?php
declare(strict_types=1);

// POST /api/tasks
require_once __DIR__ . '/TacheRepository.php';

$data = readJsonBody();

if (empty($data['title'])) {
    respondJson(['error' => 'The "title" field is required.'], 400);
}

$repository = new TacheRepository($pdo);
$id = $repository->creer($data['title'], $data['description'] ?? '');

respondJson(['id' => $id, 'message' => 'Task created successfully.'], 201);
```

```php
<?php
declare(strict_types=1);

// GET /api/tasks/{id}
$task = $repository->trouver((int) $_GET['id']);

if ($task === null) {
    respondJson(['error' => 'Task not found.'], 404);
}

respondJson($task, 200);
```

### Structuring responses consistently

A good practice: adopt a uniform response structure throughout the API, for example:

```php
<?php
// Success
['success' => true, 'data' => [...]]

// Error
['success' => false, 'error' => "Explicit error message"]
```

> 📌 This topic is covered in depth (structuring with dedicated classes, standardized pagination) in [module 09.2 — API Resources and Data Transformation](../../09-api-rest-laravel/02-api-resources-transformers/README.md), where Laravel automates this consistency.

### Handling errors cleanly in an API

```php
<?php
declare(strict_types=1);

try {
    $task = $repository->trouver($id);

    if ($task === null) {
        respondJson(['success' => false, 'error' => 'Task not found.'], 404);
    }

    respondJson(['success' => true, 'data' => $task], 200);
} catch (PDOException $e) {
    // NEVER return technical detail ($e->getMessage()) to the client:
    // it could reveal the database structure to an attacker.
    error_log($e->getMessage()); // log the real error server-side
    respondJson(['success' => false, 'error' => 'An internal error occurred.'], 500);
}
```

## ✅ Key takeaways

- REST organizes an API around resources and the standard HTTP verbs (`GET`, `POST`, `PUT`/`PATCH`, `DELETE`).
- HTTP status codes communicate the result of the request, not just the response body.
- A JSON API request body is read via `file_get_contents('php://input')`, not `$_POST`.
- Never expose the technical detail of a server error (SQL exception message...) in the response sent to the client.

## ➡️ Going further

- [restfulapi.net](https://restfulapi.net/) — reference on REST principles
- [Level 09 — REST API with Laravel](../../09-api-rest-laravel/README.en.md) (how Laravel automates all of this)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [03.3 — Unit Testing with PHPUnit](../03-tests-unitaires-phpunit/README.en.md) · **Next:** [03.5 — Best Practices, PSR-12, Clean Code](../05-bonnes-pratiques-psr-clean-code/README.en.md)
