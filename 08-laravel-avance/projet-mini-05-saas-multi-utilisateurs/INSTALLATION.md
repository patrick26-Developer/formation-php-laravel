# Installation

## Prérequis

- PHP 8.3+, Composer, Node.js/npm, MySQL/MariaDB.
- Avoir terminé les modules 08.1 à 08.5.

## Étapes

### 1. Créer le projet avec Breeze

```bash
composer create-project laravel/laravel saas-multi-utilisateurs
cd saas-multi-utilisateurs
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install
```

### 2. Adapter le modèle User

Ajoutez `tenant_id` à `$fillable` et la méthode `tenant()` dans `app/Models/User.php`
(voir `app/Models/User-additions.php` fourni ici).

### 3. Copier les fichiers de ce mini-projet

Copiez `database/`, `app/Models/Tenant.php`, `app/Models/Project.php`,
`app/Models/Task.php`, `app/Contracts/`, `app/Services/`, `app/Jobs/`,
`app/Policies/`, `app/Http/Controllers/ProjectController.php`,
`routes/web.php` (fusionnez avec celui de Breeze), `resources/views/projects/`
et `tests/Feature/` dans le projet. **Remplacez** `app/Providers/AppServiceProvider.php`
par celui fourni (liaison `RapportGenerator`).

### 4. Configurer la base de données et la file d'attente

```
# .env
DB_DATABASE=saas_multi_utilisateurs
QUEUE_CONNECTION=database
```

```bash
mysql -u root -p -e "CREATE DATABASE saas_multi_utilisateurs CHARACTER SET utf8mb4;"
php artisan queue:table
```

### 5. Migrer et peupler

```bash
php artisan migrate
```

Enregistrez le seeder dans `DatabaseSeeder::run()` : `$this->call([SaasSeeder::class]);`
```bash
php artisan db:seed
```

Vous obtenez 3 tenants (Acme Corp, Globex, Initech), chacun avec 2 utilisateurs et 4 projets garnis de tâches.

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
