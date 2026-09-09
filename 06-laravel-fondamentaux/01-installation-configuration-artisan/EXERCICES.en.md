# Exercises — 06.1 Installing Laravel and Artisan

## Exercise 1 — First installation (easy)

Install a new Laravel project. Run `php artisan serve` and confirm the homepage. Explore `routes/web.php` and `bootstrap/app.php`.

## Exercise 2 — Exploring with Tinker (easy)

Run `php artisan tinker`. Execute `echo config('app.name');`, then `echo now();` (displays the current date/time via the natively included Carbon class). Exit with `exit`.

## Exercise 3 — Generate a controller and a model (medium)

Generate a `ProduitController` controller and a `Produit` model with its migration in a single command (`make:model Produit -m -c`). Observe the created files and their location.

## Exercise 4 — Exploring routes (medium)

Add a simple route in `routes/web.php` returning a string. Run `php artisan route:list` and spot your new route in the list.

## Exercise 5 — Environment configuration (hard)

Change `APP_NAME` in `.env`, run `php artisan config:clear`, then check via Tinker that `config('app.name')` reflects the new value. Explain in a comment why a simple `.env` change might not take effect without this command (hint: the configuration cache, enabled by `php artisan config:cache` in production).

---

See [solutions/README.md](solutions/README.en.md) for the commented answer key to each exercise.
