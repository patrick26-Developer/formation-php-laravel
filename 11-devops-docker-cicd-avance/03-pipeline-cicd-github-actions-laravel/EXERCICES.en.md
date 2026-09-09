# Exercises — 11.3 Complete CI/CD Pipeline for Laravel

## Exercise 1 — Basic CI pipeline (easy)

Create `.github/workflows/ci.yml` with PHP installation, Composer, and running Pest tests (with no database to start, on a project with no migrations).

## Exercise 2 — Adding the MySQL service (easy)

Add a `mysql` service to the workflow. Run `php artisan migrate` then the tests on the [level 08 mini-project](../../08-laravel-avance/projet-mini-05-saas-multi-utilisateurs/README.en.md) (which has real migrations).

## Exercise 3 — Deliberately failing the pipeline (medium)

Introduce a test that deliberately fails. Push to a branch and watch GitHub Actions mark the workflow as failed (red X). Fix the test and verify the pipeline turns green again.

## Exercise 4 — Adding PHPStan and PHP-CS-Fixer (medium)

Install these two tools (module 05.5) on the project. Add their steps to the pipeline, BEFORE the tests. Introduce a deliberate style violation and verify it blocks the pipeline before the tests even run.

## Exercise 5 — Building and pushing an image (hard)

Add a CD job that builds the [module 11.1 mini-project](../01-dockerisation-application-laravel-complete/EXERCICES.en.md)'s Docker image and pushes it to GitHub Container Registry (`ghcr.io`), tagged both `:latest` and by commit SHA. Verify both tags in the GitHub repository's "Packages" tab.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
