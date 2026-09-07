# Exercises — 02.7 Composer, Autoloading, PSR

> These exercises require Composer installed (see [00.2](../../00-introduction/02-installation-environnement/README.en.md)). Unlike previous modules, the solutions are provided as a **complete project structure** in `solutions/`, not a single file.

## Exercise 1 — Initialize a Composer project (easy)

Create a new folder, run `composer init` (answer the questions, or create `composer.json` by hand), then add a PSR-4 `autoload` configuration mapping `App\` to the `src/` folder. Run `composer dump-autoload`.

## Exercise 2 — First autoloaded class (easy)

In the exercise 1 project, create `src/Saluer.php` with a `Saluer` class in the `App` namespace, having a method `bonjour(string $prenom): string`. From an `index.php` at the root, include only `vendor/autoload.php`, import the class with `use App\Saluer;`, instantiate it, and call the method.

## Exercise 3 — Sub-namespace (medium)

Add `src/Services/Calculatrice.php` with `namespace App\Services;`. Check that PSR-4 loads it automatically with no change to `composer.json` (the subfolder matches the sub-namespace). Use it from `index.php` with `use App\Services\Calculatrice;`.

## Exercise 4 — Install a real dependency (medium)

Install the `nesbot/carbon` library (`composer require nesbot/carbon`, a widely used date-manipulation library in the Laravel world). Use it in `index.php` to display today's date formatted in French.

## Exercise 5 — `composer.lock` in practice (hard)

Delete your `vendor/` folder (simulating "a new developer cloning the project"). Rerun only `composer install` (not `composer update`). Check in `composer.lock` that the installed versions exactly match those from before deletion. Explain in a comment why this guarantee matters for a team.

---

Compare with [solutions/](solutions/) once done — the solution there is provided as a complete, minimal Composer project, ready to inspect.
