# Installation

## Prérequis

- PHP 8.3+, Composer, Node.js/npm, MySQL/MariaDB, Docker (pour la partie 11).
- Avoir terminé les niveaux 04, 07, 08, 09 et 11.

## Installation locale (sans Docker, pour développer)

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

Ajoutez `HasApiTokens`, `tenant_id` à `$fillable`, et la relation `tenant()` dans `app/Models/User.php`.

Copiez `database/`, `app/`, `resources/views/`, `tests/Feature/`. Fusionnez `routes/`.

```
# .env
DB_DATABASE=saas_facturation
```
```bash
mysql -u root -p -e "CREATE DATABASE saas_facturation CHARACTER SET utf8mb4;"
php artisan migrate
```

Enregistrez `SaasFacturationSeeder` dans `DatabaseSeeder`, puis :
```bash
php artisan db:seed
```

## Exécution avec Docker (module 11.1)

```bash
docker compose up -d --build
docker compose exec app php artisan migrate --seed
```

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
