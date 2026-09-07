# Installation

## Prerequisites

- PHP 8.3+, Composer, MySQL/MariaDB (see [00.2](../../00-introduction/02-installation-environnement/README.en.md)).
- Having completed modules 06.1 through 06.7.

## Steps

### 1. Create a new Laravel project

```bash
composer create-project laravel/laravel blog-laravel
cd blog-laravel
```

### 2. Copy this mini-project's files

Copy the contents of this mini-project's `database/`, `app/`, `routes/`, `resources/` folders **on top of** those in the freshly created project (they complement Laravel's default structure, without overwriting anything essential — `routes/web.php` will be replaced, which is intended).

### 3. Configure the database

In `.env`:
```
DB_CONNECTION=mysql
DB_DATABASE=blog_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Create the database:
```bash
mysql -u root -p -e "CREATE DATABASE blog_laravel CHARACTER SET utf8mb4;"
```

### 4. Migrate and seed the database

```bash
php artisan migrate
```

Register the seeder in `database/seeders/DatabaseSeeder.php`:
```php
public function run(): void
{
    $this->call([BlogSeeder::class]);
}
```

Then run:
```bash
php artisan db:seed
```

You get 4 categories, each with 5 articles (80% published, 20% draft), and 0 to 4 comments per article.

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md) to launch and browse the blog.
