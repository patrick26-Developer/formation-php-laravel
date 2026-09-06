# Installation

## Prérequis

- Le [mini-projet du niveau 07 (Plateforme d'annonces)](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) déjà installé et fonctionnel.
- Avoir terminé les modules 09.1 à 09.6.

## Étapes

### 1. Installer Sanctum

```bash
composer require laravel/sanctum
php artisan vendor:publish --tag=sanctum-migrations
php artisan migrate
```

Ajoutez `use Laravel\Sanctum\HasApiTokens;` et le trait `HasApiTokens` dans `app/Models/User.php`.

### 2. Installer Pest et L5-Swagger (si non déjà fait au niveau 08)

```bash
composer require pestphp/pest --dev --with-all-dependencies
php artisan pest:install

composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

### 3. Copier les fichiers de ce mini-projet

Copiez `app/Http/Controllers/Api/`, `app/Http/Resources/`, `routes/api.php`,
et `tests/Feature/Api/` dans le projet. **Remplacez**
`app/Providers/AppServiceProvider.php` par celui fourni ici (limiteurs de débit).

> 📌 Aucune migration, modèle, Policy ou Form Request supplémentaire n'est
> nécessaire : ce mini-projet réutilise **intégralement** ceux du niveau 07.

### 4. Générer la documentation

```bash
php artisan l5-swagger:generate
```

## Vérification

Passez à [EXECUTION.md](EXECUTION.md).
