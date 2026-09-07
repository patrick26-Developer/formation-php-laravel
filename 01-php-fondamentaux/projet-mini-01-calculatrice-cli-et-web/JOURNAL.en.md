# Build Journal

> This journal retraces the construction of the project in order, so you can follow — or reproduce from memory — the same approach.

## Step 1 — Isolate the business logic

Before writing a single interface (CLI or Web), we write `src/Calculatrice.php`: two typed functions, `calculer()` and `diviser()`, which know **nothing** about the terminal or HTML. This is the central principle of this project: the calculation logic is independent of how it is used.

`calculer()` uses a `match` (module 01.2) to pick the operation, and throws an `InvalidArgumentException` (module 01.9) if the operation is unknown. `diviser()` does the same for the division-by-zero case — this function centralizes the "you cannot divide by zero" business rule in a single place, no matter who calls it afterward.

## Step 2 — The CLI interface

`src/cli.php` reads command-line arguments via the `$argv` superglobal. `$argv[0]` is always the script's name, so the real arguments (`number1`, `operation`, `number2`) start at index 1 — we use destructuring, `[, $a, $op, $b] = $argv;`, to cleanly skip index 0.

We validate that the right number of arguments was provided and that the numbers are indeed numeric, then call `calculer()` inside a `try`/`catch`. On error, the message is written to `STDERR` (the standard error stream, not normal output) and the script exits with `exit(1)` — a Unix convention that signals failure to any script that would call this program.

## Step 3 — The Web interface

`src/web/index.php` includes `Calculatrice.php` with `require_once` (module 01.8), then reproduces the pattern seen in module 01.7: a form that submits to itself via `POST`, validation of the received data, and the same call to `calculer()` inside a `try`/`catch` — but this time the error is displayed inside an HTML `<p>` tag, escaped with `htmlspecialchars()`.

The operations dropdown menu is generated dynamically from `operationsDisponibles()`, defined in `Calculatrice.php`: if an operation is added later (for example `%` for modulo), it only needs to be added to that function and to `calculer()`'s `match` — both interfaces will update automatically, without duplicating the list of operations.

## Step 4 — Cross-verification

Final step: verifying that a division by zero produces consistent behavior on both interfaces, since they call the same `diviser()` function. This is proof that the logic/interface separation works: fixing a bug in `Calculatrice.php` fixes it simultaneously everywhere this logic is used.

## Going further (out of scope for this mini-project)

This project deliberately keeps things simple (no classes, no automated tests). Those concepts arrive starting with [Level 02](../../02-php-intermediaire/README.md) (object-oriented programming) and [module 03.3](../../03-php-avance/03-tests-unitaires-phpunit/README.md) (unit testing) — you'll naturally come back to them.
