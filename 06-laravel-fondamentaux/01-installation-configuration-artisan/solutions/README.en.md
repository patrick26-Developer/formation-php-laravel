# Solutions — 06.1 Installing Laravel and Artisan

## Exercise 1

```bash
composer create-project laravel/laravel exercice-laravel
cd exercice-laravel
php artisan serve
```
`routes/web.php` contains a single default route (`/` → a welcome view). `bootstrap/app.php` returns a configured instance of the application, with commented sections for adding routes, middlewares, and exception handling.

## Exercise 2

```bash
php artisan tinker
>>> echo config('app.name');
Laravel
>>> echo now();
2026-09-06 14:32:10
>>> exit
```

## Exercise 3

```bash
php artisan make:model Produit -m -c
```
Creates `app/Models/Produit.php`, `app/Http/Controllers/ProduitController.php`, and `database/migrations/xxxx_xx_xx_create_produits_table.php`. A single command covers all three files related to this resource.

## Exercise 4

```php
// routes/web.php
Route::get('/bonjour', function () {
    return 'Hello from my route!';
});
```
```bash
php artisan route:list
# GET|HEAD  bonjour ................................
```

## Exercise 5

```bash
# .env
APP_NAME="My Modified Application"
```
```bash
php artisan config:clear
php artisan tinker
>>> echo config('app.name');
My Modified Application
```

Explanation: in development, Laravel reads `.env` on every request (no active cache by default), so a change should already be visible without `config:clear`. **But** if `php artisan config:cache` has already been run once (typically done in production for performance), Laravel then reads a frozen cache file (`bootstrap/cache/config.php`) instead of `.env` — `config:clear` removes this cache and forces a fresh read. This is a very common source of confusion for Laravel beginners: "I changed my `.env` but nothing happens" is almost always fixed by `php artisan config:clear`.
