# Installation

## Prerequisites

- The [level 07 mini-project (Classifieds Platform)](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md) already installed and working.
- Having completed modules 09.1 through 09.6.

## Steps

### 1. Install Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --tag=sanctum-migrations
php artisan migrate
```

Add `use Laravel\Sanctum\HasApiTokens;` and the `HasApiTokens` trait in `app/Models/User.php`.

### 2. Install Pest and L5-Swagger (if not already done in level 08)

```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install

composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

### 3. Copy this mini-project's files

Copy `app/Http/Controllers/Api/`, `app/Http/Resources/`, `routes/api.php`,
and `tests/Feature/Api/` into the project. **Replace**
`app/Providers/AppServiceProvider.php` with the one provided here (rate limiters).

> 📌 No additional migration, model, Policy, or Form Request is
> needed: this mini-project **entirely** reuses those from level 07.

### 4. Generate the documentation

```bash
php artisan l5-swagger:generate
```

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md).
