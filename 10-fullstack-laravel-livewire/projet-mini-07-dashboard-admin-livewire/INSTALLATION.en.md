# Installation

## Prerequisites

- The [level 07 mini-project (Classifieds Platform)](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md) already installed and working.
- Having completed modules 10.1 through 10.4.

## Steps

### 1. Install Livewire

```bash
composer require livewire/livewire
composer require pestphp/pest-plugin-livewire --dev
```

### 2. Add the admin-access Gate

In `app/Providers/AppServiceProvider.php`, `boot()` method:
```php
use Illuminate\Support\Facades\Gate;

Gate::define('acceder-admin', fn ($user) => $user->est_admin);
```

### 3. Copy this mini-project's files

Copy `database/migrations/`, `app/Livewire/`, `resources/views/admin/`,
`resources/views/livewire/`, `tests/Feature/AnnoncesTableTest.php`, and
merge `routes/web.php` with the existing one.

### 4. Migrate and create an admin account

```bash
php artisan migrate
php artisan tinker
>>> \App\Models\User::first()->update(['est_admin' => true]);
```

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md).
