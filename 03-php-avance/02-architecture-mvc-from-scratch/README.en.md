# 03.2 — Building an MVC Architecture from Scratch

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the role of each of the three layers of the MVC pattern.
- Build a homemade router that directs a URL to a controller.
- Clearly separate Model, View, and Controller in a real mini-project.
- Understand why Laravel is architected this way.

## 📋 Prerequisites

[03.1 — Design Patterns in PHP](../01-design-patterns-php/README.en.md)

## ⏱️ Estimated duration

3h.

## 📖 Theory

### The MVC pattern: three separate responsibilities

| Layer | Responsibility | Example in what you've already written |
|---|---|---|
| **Model** | Data and business logic | `TacheRepository` (module 02.9) |
| **View** | Display (HTML) | The `<?php foreach ... ?>` blocks mixed with HTML |
| **Controller** | Receives the request, orchestrates Model and View | The body of `index.php`, `creer.php`... |

Until now, in the level 02 mini-project, these three responsibilities were mixed together in the same file (`index.php` handled the HTTP request, the logic, and the display all at once). This module **explicitly** separates these responsibilities into distinct classes and folders.

### A homemade router

Without a framework, every URL maps directly to a PHP file (`creer.php`, `modifier.php`...). A **router** centralizes this URL → code mapping, just like Laravel does ([module 06.2](../../06-laravel-fondamentaux/02-routing-controllers/README.md)).

```php
<?php
declare(strict_types=1);

namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $method, string $path, callable $handler): void {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
        ];
    }

    public function get(string $path, callable $handler): void {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void {
        $this->add('POST', $path, $handler);
    }

    public function dispatch(string $method, string $uri): void {
        $path = strtok($uri, '?'); // ignore the query string for comparison

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $path) {
                ($route['handler'])();
                return;
            }
        }

        http_response_code(404);
        echo "Page not found.";
    }
}
```

### A single entry point (`front controller`)

Every request goes through **a single file** (`public/index.php`), which then delegates to the router — unlike level 02's "one file per page" approach.

```php
<?php
// public/index.php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;
use App\Controllers\TaskController;

$router = new Router();

$controller = new TaskController();
$router->get('/tasks', [$controller, 'index']);
$router->get('/tasks/create', [$controller, 'createForm']);
$router->post('/tasks', [$controller, 'store']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
```

> 📌 This is exactly what Laravel does: **every** request goes through `public/index.php`, which loads the framework and dispatches to the right controller based on the routes defined in `routes/web.php` (covered in detail in [module 06.2](../../06-laravel-fondamentaux/02-routing-controllers/README.md)).

### The controller: orchestrate, never do the work itself

```php
<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\TacheRepository;
use App\Core\View;

class TaskController {
    public function __construct(private TacheRepository $tasks) {}

    public function index(): void {
        $tasks = $this->tasks->lister();

        View::render('tasks/index', ['tasks' => $tasks]);
    }

    public function store(): void {
        $title = $_POST['title'] ?? '';

        $this->tasks->creer($title);

        header('Location: /tasks');
        exit;
    }
}
```

A good controller is **short**: it retrieves the needed data, calls the Model layer, then delegates rendering to the View. It contains no SQL, no complex business logic, and no HTML.

### The view: a simple template-inclusion engine

```php
<?php
declare(strict_types=1);

namespace App\Core;

class View {
    public static function render(string $viewName, array $data = []): void {
        extract($data); // turns ['tasks' => [...]] into a $tasks variable
        require __DIR__ . "/../../views/$viewName.php";
    }
}
```

`views/tasks/index.php`:
```php
<h1>My Tasks</h1>
<ul>
    <?php foreach ($tasks as $task): ?>
        <li><?= htmlspecialchars($task['titre']) ?></li>
    <?php endforeach; ?>
</ul>
```

> 📌 `extract()` is used here purely to illustrate the underlying mechanism of a simplified view engine. Blade, Laravel's templating engine ([module 06.3](../../06-laravel-fondamentaux/03-blade-templates/README.md)), fundamentally does the same thing, adding a richer syntax (`@foreach`, `@if`, layout inheritance...).

### Overview of a request's flow

```
HTTP Request → public/index.php (single entry point)
             → Router (finds the right route)
             → Controller (orchestrates)
             → Model/Repository (accesses data)
             → View (renders the result)
             → HTTP Response
```

This is, broadly speaking, the flow that **every** request follows in a Laravel application.

## ✅ Key takeaways

- MVC separates data (Model), display (View), and orchestration (Controller).
- A router maps an HTTP method + a URL to a handler.
- A single "front controller" (`public/index.php`) receives every request.
- A controller stays short: it delegates to the Model and the View, without doing the work itself.
- Understanding this architecture "by hand" makes Laravel's structure (routes/web.php, app/Http/Controllers, resources/views) immediately readable.

## ➡️ Going further

- [Module 06.2 — Routing and Controllers (Laravel)](../../06-laravel-fondamentaux/02-routing-controllers/README.md) *(French only)*
- [Large Project 01 — MVC Mini-Framework with API](../grand-projet-01-mini-framework-mvc-avec-api/README.md) *(French only)* (this module fully applied)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [03.1 — Design Patterns in PHP](../01-design-patterns-php/README.en.md) · **Next:** [03.3 — Unit Testing with PHPUnit](../03-tests-unitaires-phpunit/README.en.md)
