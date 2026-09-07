# Installation

## Prerequisites

- PHP 8.3+ with the `pdo_mysql` extension enabled.
- An accessible MySQL/MariaDB server (see [00.2 — Environment Setup](../../00-introduction/02-installation-environnement/README.en.md)).
- **No Composer dependency** for this project (deliberate, see [README.md](README.en.md)).

## Steps

### 1. Create the database

Run the provided SQL script, for example with the MySQL command-line client:

```bash
mysql -u root -p < sql/schema.sql
```

Or paste its contents into phpMyAdmin / your usual SQL client.

### 2. Configure the connection

Copy the template configuration file:

```bash
cp config.example.php config.php
```

Open `config.php` and adjust `db_host`, `db_user`, `db_password` to match your local setup (the defaults work for a standard Laragon/XAMPP install with the `root` user and no password).

> ⚠️ `config.php` is listed in `.gitignore`: it will never be version-controlled, since it could contain sensitive credentials in a real-world context.

### 3. Create a demo user

```bash
php src/seed.php
```

This creates a `demo@example.com` / `demo1234` account, using `password_hash()` — never a plain-text password written into a SQL script (see [module 02.5](../05-sessions-cookies-authentification-maison/README.en.md)).

### Verification

Move on to [EXECUTION.md](EXECUTION.en.md) to launch the application and log in with this account.
