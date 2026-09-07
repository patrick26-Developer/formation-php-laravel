# Installation

## Prerequisites

- PHP 8.3+, Composer, Node.js/npm, MySQL/MariaDB.
- Having completed at minimum level 07 and module 09.3 (Sanctum).

## Steps

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

Add `HasApiTokens` (Sanctum) and the content of `app/Models/User-additions.php` into `app/Models/User.php`.

Copy `database/`, `app/`, `resources/views/posts/`, `tests/Feature/FeedTest.php`. Merge `routes/web.php` and `routes/api.php` with Breeze's.

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

Register `ReseauSocialSeeder` in `DatabaseSeeder`, then:
```bash
php artisan db:seed
```

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md).
