# Installation

## Prerequisites

- PHP 8.3+, Composer, Node.js/npm, MySQL/MariaDB.
- Having completed modules 08.1 through 08.5.

## Steps

### 1. Create the project with Breeze

```bash
composer create-project laravel/laravel saas-multi-utilisateurs
cd saas-multi-utilisateurs
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### 2. Adapt the User model

Add `tenant_id` to `$fillable` and the `tenant()` method in `app/Models/User.php`
(see `app/Models/User-additions.php` provided here).

### 3. Copy this mini-project's files

Copy `database/`, `app/Models/Tenant.php`, `app/Models/Project.php`,
`app/Models/Task.php`, `app/Contracts/`, `app/Services/`, `app/Jobs/`,
`app/Policies/`, `app/Http/Controllers/ProjectController.php`,
`routes/web.php` (merge with Breeze's), `resources/views/projects/`
and `tests/Feature/` into the project. **Replace** `app/Providers/AppServiceProvider.php`
with the one provided here (the `RapportGenerator` binding).

### 4. Configure the database and the queue

```
# .env
DB_DATABASE=saas_multi_utilisateurs
QUEUE_CONNECTION=database
```

```bash
mysql -u root -p -e "CREATE DATABASE saas_multi_utilisateurs CHARACTER SET utf8mb4;"
php artisan queue:table
```

### 5. Migrate and seed

```bash
php artisan migrate
```

Register the seeder in `DatabaseSeeder::run()`: `$this->call([SaasSeeder::class]);`
```bash
php artisan db:seed
```

You get 3 tenants (Acme Corp, Globex, Initech), each with 2 users and 4 projects filled with tasks.

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md).
