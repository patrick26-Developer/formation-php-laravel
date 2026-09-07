# 06.1 — Installing Laravel and Artisan

> **Status:** ✅ Available

## 🎯 Objectives

- Install a modern Laravel project.
- Understand a Laravel application's folder structure.
- Use the essential Artisan commands.
- Configure environment variables.

## 📋 Prerequisites

[Level 05 — Professional Tools](../../05-outils-professionnels/README.en.md) completed.

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Installing Laravel

```bash
composer create-project laravel/laravel my-project
cd my-project
php artisan serve
```

Open `http://localhost:8000`: the Laravel welcome page confirms everything works.

> 📌 `composer create-project` does exactly what you did manually in [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md) and the [level 03 large project](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.en.md): it downloads Laravel (a Composer dependency like any other) along with its PSR-4 autoloading, already configured for you.

### The structure of a modern Laravel project

Since Laravel 11, the structure has been **streamlined** compared to earlier versions — an important point to know if you're reading older tutorials:

```
my-project/
├── app/
│   ├── Http/Controllers/    # your controllers (module 06.2)
│   ├── Models/                # your Eloquent models (module 06.4)
│   └── Providers/               # Service Providers (module 08.4)
├── bootstrap/
│   └── app.php                    # central configuration: routes, middlewares, exceptions (new since Laravel 11)
├── config/                          # configuration files (database.php, mail.php...)
├── database/
│   ├── migrations/                     # versioned database schema (module 06.5)
│   ├── seeders/                          # test data (module 06.5)
│   └── factories/                          # fake data generation (module 06.5)
├── public/
│   └── index.php                             # THE single entry point (front controller, module 03.2)
├── resources/
│   └── views/                                  # Blade templates (module 06.3)
├── routes/
│   ├── web.php                                   # browser routes (with sessions, CSRF)
│   └── api.php                                     # API routes (module 09), stateless
├── storage/                                          # generated files (logs, cache, uploads)
├── tests/                                              # Pest/PHPUnit tests (module 08.3)
├── .env                                                  # environment variables (NEVER version-controlled)
├── artisan                                                 # the Artisan CLI executable
└── composer.json
```

> 📌 **Before Laravel 11**, middleware and exception configuration lived in `app/Http/Kernel.php` and `app/Exceptions/Handler.php`. These files have been **removed from the default skeleton**: everything is now configured centrally in `bootstrap/app.php`. If you come across a tutorial that mentions `Kernel.php`, know that it documents an earlier version — the concept is still valid, only the location has changed.

### Recognizing what you already know

| What you built (Level 03) | Its Laravel equivalent |
|---|---|
| `Routeur.php` (module 03.2) | `routes/web.php` + Laravel's internal router |
| `Vue.php` (module 03.2) | The Blade engine (module 06.3) |
| `TacheRepository.php` (module 02.9) | An Eloquent model (module 06.4) |
| `Database.php` (PDO Singleton) | The connection managed automatically via `config/database.php` |
| `public/index.php` (front controller) | `public/index.php` (identical in principle) |

### The `.env` file

```
# .env
APP_NAME="My Project"
APP_ENV=local
APP_KEY=base64:...           # generated automatically, used for encryption
APP_DEBUG=true                 # shows detailed errors in development (NEVER true in production)

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_project
DB_USERNAME=root
DB_PASSWORD=
```

> 📌 This file directly replaces the `config.php` you hand-wrote in [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.en.md) and the [level 03 large project](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.en.md). It is **never version-controlled** (`.gitignore` excludes it by default); `.env.example` serves as a version-controlled template, exactly like your earlier `config.example.php` files.

### The essential Artisan commands

```bash
php artisan --version              # installed Laravel version
php artisan list                     # lists all available commands
php artisan tinker                     # a PHP REPL with the Laravel application already loaded (variables, models...)

php artisan make:controller TacheController    # generates a controller
php artisan make:model Tache -m                  # generates a model + its migration (-m)
php artisan make:migration create_taches_table     # generates a migration alone

php artisan migrate                                  # runs pending migrations (module 06.5)
php artisan route:list                                 # lists every route in the application

php artisan config:clear                                 # clears the configuration cache (useful after editing .env)
```

> 💡 `php artisan tinker` is the equivalent of `php -a` (module 01.9) but with **your entire Laravel application already loaded**: you can test `App\Models\Tache::count()` directly there, with no script to write.

## ✅ Key takeaways

- `composer create-project laravel/laravel` installs Laravel like any other Composer dependency.
- Since Laravel 11, `bootstrap/app.php` centralizes configuration (routes, middlewares, exceptions) — `Kernel.php` no longer exists by default.
- `.env` replaces your homemade configuration files; it's never version-controlled.
- `php artisan make:*` generates code that follows Laravel conventions — use it systematically rather than creating files by hand.

## ➡️ Going further

- [laravel.com/docs — Installation](https://laravel.com/docs/installation)
- [laravel.com/docs — Artisan Console](https://laravel.com/docs/artisan)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [Level 05 — Professional Tools](../../05-outils-professionnels/README.en.md) · **Next:** [06.2 — Routing and Controllers](../02-routing-controllers/README.en.md)
