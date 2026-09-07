# Build Journal

## Step 1 — The Composer foundation

Unlike the level 02 mini-project (manual `require_once`, deliberately), this project starts directly with a `composer.json` defining PSR-4 autoloading (`App\` → `src/`) — the mechanism from [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md), applied from the very start, since a project with a router/controllers/models quickly multiplies the number of classes.

## Step 2 — The core (`src/Core/`)

`Routeur.php` reuses the implementation from [module 03.2](../02-architecture-mvc-from-scratch/README.en.md), enriched with middleware support (exercise 5 of that same module) — even though this project doesn't actively use them, the capability is there to, for example, protect `/taches/creer` with authentication in a future evolution.

`Vue.php` reuses the `extract()`-based mini template engine from the same module. `Reponse.php` centralizes the JSON helpers from [module 03.4](../04-construction-api-rest-php-natif/README.en.md) (`json()`, `corpsJson()`), so they're written once and reused by `TacheApiController`.

## Step 3 — The Model: a single `TacheRepository` for two interfaces

This is the central architectural decision of this project: `TacheRepository` (reused almost as-is from [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md)) knows **nothing** about HTML or JSON. It exposes methods that return raw PHP arrays (`creer()`, `trouver()`, `lister()`...). It's up to the **controllers** to decide how to present this data — HTML for one, JSON for the other.

## Step 4 — Two controllers, one single logic

Both `TacheWebController::liste()` and `TacheApiController::liste()` call `$this->taches->lister(...)` with the same parameters (sort, search, pagination) — the only difference is what they do with the result: one passes it to `Vue::afficher()`, the other to `Reponse::json()`. If a bug is fixed in `TacheRepository::lister()`, it's fixed **simultaneously** for the web and the API — concrete proof of the value of this separation, already glimpsed at level 02.

## Step 5 — The front controller (`public/index.php`)

Every route (web and API) is declared in the same place, on the same `Routeur` instance. This file forms the complete map of the application's URLs — exactly the role that `routes/web.php` (and `routes/api.php`) play in Laravel, covered in [module 06.2](../../06-laravel-fondamentaux/02-routing-controllers/README.md).

## Step 6 — Tests, without depending on MySQL

Rather than setting up a test MySQL database (slow to reset between each test, and which would make this project's tests dependent on an external service), `tests/TacheRepositoryTest.php` uses **in-memory SQLite** (`new PDO('sqlite::memory:')`). Since `TacheRepository` only uses standard SQL (no MySQL-specific functions), it works identically on both engines — a concrete example of the value of PDO as an abstraction layer (covered in [module 02.8](../../02-php-intermediaire/08-pdo-bases-de-donnees-mysql/README.en.md)). Each test recreates a fresh database in `setUp()`: no test can therefore be affected by data left behind by another.

## Going further (out of scope for this project)

This mini-framework handles neither authentication nor automatic dependency injection (a "service container", which Laravel calls the Service Container) — controllers are instantiated manually in `public/index.php`. This is deliberate: understanding this manual wiring once makes what Laravel automates immediately clear, starting at [Level 06](../../06-laravel-fondamentaux/README.md).
