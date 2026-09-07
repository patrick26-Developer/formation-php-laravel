# Installation

## Prérequis

- Le [mini-projet du niveau 07 (Plateforme d'annonces)](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) déjà installé et fonctionnel.
- Avoir terminé les modules 10.1 à 10.4.

## Étapes

### 1. Installer Livewire

```bash
composer require livewire/livewire
composer require pestphp/pest-plugin-livewire --dev
```

### 2. Ajouter le Gate d'accès admin

Dans `app/Providers/AppServiceProvider.php`, méthode `boot()` :
```php
use Illuminate\Support\Facades\Gate;

Gate::define('acceder-admin', fn ($user) => $user->est_admin);
```

### 3. Copier les fichiers de ce mini-projet

Copiez `database/migrations/`, `app/Livewire/`, `resources/views/admin/`,
`resources/views/livewire/`, `tests/Feature/AnnoncesTableTest.php`, et
fusionnez `routes/web.php` avec celui déjà existant.

### 4. Migrer et créer un compte admin

```bash
php artisan migrate
php artisan tinker
>>> \App\Models\User::first()->update(['est_admin' => true]);
```

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
