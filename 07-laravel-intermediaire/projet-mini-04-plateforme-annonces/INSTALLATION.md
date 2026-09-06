# Installation

## Prérequis

- PHP 8.3+, Composer, Node.js/npm (pour les assets Breeze), MySQL/MariaDB.
- Avoir terminé les modules 07.1 à 07.7.

## Étapes

### 1. Créer le projet et installer Breeze

```bash
composer create-project laravel/laravel plateforme-annonces
cd plateforme-annonces
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
```

### 2. Ajouter les relations au modèle User

Ouvrez `app/Models/User.php` (généré par Breeze) et ajoutez-y le contenu de
`app/Models/User-additions.php` fourni ici (méthodes `annonces()` et `favoris()`).

### 3. Copier les fichiers de ce mini-projet

Copiez `database/`, `app/Models/Category.php`, `app/Models/Annonce.php`,
`app/Models/Message.php`, `app/Policies/`, `app/Notifications/`,
`app/Http/Controllers/`, `app/Http/Requests/`, `routes/web.php` (fusionnez
avec celui de Breeze : gardez son `require __DIR__.'/auth.php'`) et
`resources/views/` dans le projet.

### 4. Configurer la base de données et le stockage

```
# .env
DB_DATABASE=plateforme_annonces
MAIL_MAILER=log
```

```bash
mysql -u root -p -e "CREATE DATABASE plateforme_annonces CHARACTER SET utf8mb4;"
php artisan storage:link
php artisan notifications:table
```

### 5. Migrer et peupler

```bash
php artisan migrate
```

Enregistrez le seeder dans `DatabaseSeeder::run()` :
```php
$this->call([AnnoncesSeeder::class]);
```
```bash
php artisan db:seed
```

Vous obtenez 6 catégories, 5 utilisateurs (mot de passe par défaut des factories Breeze : `password`), et 30 annonces réparties entre eux.

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
