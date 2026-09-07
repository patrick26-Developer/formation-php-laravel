# Installation

## Prerequisites

- PHP 8.3+, Composer, Node.js/npm, MySQL/MariaDB, Docker (for the Docker section).
- Having completed levels 04, 07, 08, 09, and 11.

## Local installation (without Docker, for development)

```bash
composer create-project laravel/laravel saas-facturation
cd saas-facturation
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
composer require laravel/sanctum
php artisan vendor:publish --tag=sanctum-migrations
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

Add `HasApiTokens`, `tenant_id` to `$fillable`, and the `tenant()` relationship in `app/Models/User.php`.

Copy `database/`, `app/`, `resources/views/`, `tests/Feature/`. Merge `routes/`.

```
# .env
DB_DATABASE=saas_facturation
```
```bash
mysql -u root -p -e "CREATE DATABASE saas_facturation CHARACTER SET utf8mb4;"
php artisan migrate
```

Register `SaasFacturationSeeder` in `DatabaseSeeder`, then:
```bash
php artisan db:seed
```

## Running with Docker (module 11.1)

```bash
docker compose up -d --build
docker compose exec app php artisan migrate --seed
```

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md).
