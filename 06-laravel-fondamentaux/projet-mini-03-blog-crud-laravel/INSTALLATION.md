# Installation

## Prérequis

- PHP 8.3+, Composer, MySQL/MariaDB (voir [00.2](../../00-introduction/02-installation-environnement/README.md)).
- Avoir terminé les modules 06.1 à 06.7.

## Étapes

### 1. Créer un nouveau projet Laravel

```bash
composer create-project laravel/laravel blog-laravel
cd blog-laravel
```

### 2. Copier les fichiers de ce mini-projet

Copiez le contenu des dossiers `database/`, `app/`, `routes/`, `resources/` de ce mini-projet **par-dessus** ceux du projet fraîchement créé (ils complètent la structure par défaut de Laravel, sans rien écraser d'essentiel — `routes/web.php` sera remplacé, c'est voulu).

### 3. Configurer la base de données

Dans `.env` :
```
DB_CONNECTION=mysql
DB_DATABASE=blog_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Créez la base :
```bash
mysql -u root -p -e "CREATE DATABASE blog_laravel CHARACTER SET utf8mb4;"
```

### 4. Migrer et peupler la base

```bash
php artisan migrate
```

Enregistrez le seeder dans `database/seeders/DatabaseSeeder.php` :
```php
public function run(): void
{
    $this->call([BlogSeeder::class]);
}
```

Puis exécutez :
```bash
php artisan db:seed
```

Vous obtenez 4 catégories, chacune avec 5 articles (80% publiés, 20% en brouillon), et 0 à 4 commentaires par article.

## Vérification

Passez à [EXECUTION.md](EXECUTION.md) pour lancer et parcourir le blog.
