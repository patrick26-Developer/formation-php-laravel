# Installation

## Prérequis

- PHP 8.3+, Composer, Node.js/npm, MySQL/MariaDB.
- Avoir terminé au minimum le niveau 07 et le module 09.3 (Sanctum).

## Étapes

```bash
composer create-project laravel/laravel reseau-social-minimal
cd reseau-social-minimal
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
composer require laravel/sanctum
php artisan vendor:publish --tag=sanctum-migrations
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

Ajoutez `HasApiTokens` (Sanctum) et le contenu de `app/Models/User-additions.php` dans `app/Models/User.php`.

Copiez `database/`, `app/`, `resources/views/posts/`, `tests/Feature/FeedTest.php`. Fusionnez `routes/web.php` et `routes/api.php` avec ceux de Breeze.

```
# .env
DB_DATABASE=reseau_social_minimal
```
```bash
mysql -u root -p -e "CREATE DATABASE reseau_social_minimal CHARACTER SET utf8mb4;"
php artisan migrate
php artisan notifications:table
php artisan migrate
```

Enregistrez `ReseauSocialSeeder` dans `DatabaseSeeder`, puis :
```bash
php artisan db:seed
```

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
