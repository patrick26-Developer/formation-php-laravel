# Installation

## Prerequisites

- PHP 8.3+ with the `pdo_mysql` and `pdo_sqlite` extensions (the latter for the tests).
- [Composer](https://getcomposer.org) installed (see [00.2](../../00-introduction/02-installation-environnement/README.en.md)).
- A MySQL/MariaDB server (for the application itself — the tests don't need one).

## Steps

### 1. Install the dependencies

```bash
composer install
```

This command installs PHPUnit (declared as `require-dev` in `composer.json`) and generates the PSR-4 autoload file (`vendor/autoload.php`), which lets `App\Core\Routeur`, `App\Models\TacheRepository`, etc. be loaded automatically without a single manual `require_once` — the mechanism covered in [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md), finally applied in real conditions.

### 2. Create the database

```bash
mysql -u root -p < sql/schema.sql
```

### 3. Configure the connection

```bash
cp config.example.php config.php
```

Adjust `config.php` to match your local setup.

## Verification

Move on to [EXECUTION.md](EXECUTION.en.md) to start the server, run the tests, and try out the API.
