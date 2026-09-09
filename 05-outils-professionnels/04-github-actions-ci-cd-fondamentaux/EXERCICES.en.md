# Exercises — 05.4 GitHub Actions: CI/CD Fundamentals

> Requires a real GitHub repository (public or private) to observe workflow runs in the "Actions" tab.

## Exercise 1 — First workflow (easy)

Create `.github/workflows/hello.yml` that triggers on every `push` and simply runs `echo "Hello from GitHub Actions"`. Push and check its run in the Actions tab.

## Exercise 2 — Running PHPUnit in CI (easy)

Reuse the [Level 03 large project](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.en.md) (its tests use SQLite, no extra service needed). Create a workflow that installs PHP 8.3, runs `composer install`, then `./vendor/bin/phpunit`.

## Exercise 3 — PHP version matrix (medium)

Modify exercise 2's workflow to use a `strategy.matrix` testing the code on PHP 8.2 **and** 8.3, to check compatibility across several versions.

## Exercise 4 — Adding a MySQL service (medium)

Create a second workflow with a `mysql` service (as in the lesson), running a simple check query (`mysql -h 127.0.0.1 -uroot -psecret -e "SELECT 1"`) to confirm the service is reachable from the job.

## Exercise 5 — Complete pipeline with several jobs (hard)

Create a workflow with two separate jobs: `tests` (PHPUnit) and `qualite` (a command simulating PHP-CS-Fixer in `--dry-run`, even without actually installing it — a simple `echo` is enough for the exercise). Make `qualite` run **only after** `tests` succeeds, using `needs:`.

---

Compare with [solutions/](solutions/README.en.md) once done.
