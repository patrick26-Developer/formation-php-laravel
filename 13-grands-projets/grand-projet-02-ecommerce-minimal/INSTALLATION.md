# Installation

## Prérequis

- PHP 8.3+, Composer, Node.js/npm, MySQL/MariaDB.
- Avoir terminé au minimum les niveaux 06, 07 et le module 04.2 (transactions).

## Étapes

### 1. Créer le projet avec Breeze et Pest

```bash
composer create-project laravel/laravel ecommerce-minimal
cd ecommerce-minimal
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### 2. Ajouter la relation au modèle User

Ajoutez le contenu de `app/Models/User-additions.php` dans `app/Models/User.php` généré par Breeze.

### 3. Copier les fichiers de ce projet

Copiez `database/`, `app/` (Models, Contracts, Services, Exceptions, Policies, Http/Controllers), `resources/views/`, `tests/Feature/CheckoutTest.php`. Fusionnez `routes/web.php` avec celui de Breeze. **Remplacez** `app/Providers/AppServiceProvider.php`.

### 4. Base de données et seed

```
# .env
DB_DATABASE=ecommerce_minimal
```
```bash
mysql -u root -p -e "CREATE DATABASE ecommerce_minimal CHARACTER SET utf8mb4;"
php artisan migrate
```

Enregistrez `EcommerceSeeder` dans `DatabaseSeeder::run()`, puis :
```bash
php artisan db:seed
```

### 5. Créer un compte admin

```bash
php artisan tinker
>>> \App\Models\User::first()->update(['est_admin' => true]);
```

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
