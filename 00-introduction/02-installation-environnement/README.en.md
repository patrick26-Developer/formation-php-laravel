# 00.2 — Environment Setup

> **Status:** ✅ Available

## 🎯 Objectives

- Have PHP installed and working from the command line.
- Have Composer (the PHP dependency manager) installed.
- Have a code editor configured for PHP.
- Know how to start a local PHP server and run a first script.

## 📋 Prerequisites

[00.1 — Path Overview](../01-presentation-parcours/README.en.md)

## ⏱️ Estimated duration

30 to 45 minutes (depending on your operating system).

## 📖 Theory: what do we need?

To develop in PHP and then in Laravel, you need at minimum:

1. **PHP** (the language interpreter) — version **8.3 or higher** recommended for the whole training.
2. **Composer** — the PHP dependency manager (the equivalent of `npm` for Node.js). Laravel and nearly every modern PHP library is installed via Composer.
3. **A code editor** — VS Code (free) is recommended for this training.
4. **A local server** — to run PHP in a browser (PHP includes a built-in development server, sufficient for the entire beginning of the path).
5. **MySQL/MariaDB** — required starting at level 02 (PDO). Can be installed later, or right away via an all-in-one tool.

> 💡 Two possible approaches: install each tool separately (what this module covers in detail), or use **Docker** directly (covered in detail in [module 05.2](../../05-outils-professionnels/02-docker-fondamentaux/README.en.md)). To get started, the classic local installation is easier to understand — you'll come back to Docker once the basics are solid.

## 💡 Installing PHP

### Windows

Two recommended options:

- **Laragon** (recommended for beginners): downloads PHP, MySQL, a web server (Nginx/Apache), and phpMyAdmin in a single package. Official site: `laragon.org`.
- **Manual installation**: download PHP (the "Thread Safe" build) from `windows.php.net/download`, unzip it into `C:\php`, then add `C:\php` to the `PATH` environment variable.

Then verify in a terminal (PowerShell):

```powershell
php -v
```

You should see the installed PHP version displayed (e.g., `PHP 8.3.x`).

### macOS

With [Homebrew](https://brew.sh):

```bash
brew install php
php -v
```

### Linux (Debian/Ubuntu)

```bash
sudo apt update
sudo apt install php-cli php-mbstring php-xml php-curl php-mysql unzip
php -v
```

## 💡 Installing Composer

Composer is installed **after** PHP, since it is itself a PHP script.

- **Windows**: download and run `Composer-Setup.exe` from `getcomposer.org`.
- **macOS / Linux**:

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

Verify the installation:

```bash
composer -V
```

> ⚠️ Composer is **essential** starting at level 02 (module 02.7) and for anything Laravel. Don't skip this step even as a beginner: you'll need it soon.

## 💡 Code editor: VS Code

1. Download VS Code: `code.visualstudio.com`.
2. Install the recommended extensions:
   - **PHP Intelephense** — PHP autocompletion and analysis.
   - **PHP Debug** — step-by-step debugging (Xdebug).
   - **Laravel Blade Snippets** — useful starting at level 06.
   - **GitLens** — view Git history directly in the editor.

## 💡 Running your first PHP script

Create a `hello.php` file:

```php
<?php

echo "Hello, PHP!";
```

Run it from the command line:

```bash
php hello.php
```

Or start PHP's **built-in development server** (no additional installation needed) from the folder containing your files:

```bash
php -S localhost:8000
```

Then open `http://localhost:8000/hello.php` in your browser.

> 📌 This `php -S` command will be your best friend throughout level 01: no need for Apache or Nginx to start learning.

## 💡 Installing MySQL (for later, level 02+)

- If you installed **Laragon**, MySQL is already included and can be started from its interface.
- Otherwise: download **MySQL Community Server** (`dev.mysql.com/downloads`) or **MariaDB** (`mariadb.org`).
- A graphical tool like **phpMyAdmin** or **TablePlus** makes it easier to view data early on.

## ✅ Key takeaways

- `php -v` should display a version ≥ 8.3.
- `composer -V` should work: this is the tool you'll use to **install each project's dependencies** throughout this training (`composer install`).
- `php -S localhost:8000` is enough to test PHP code without a complex web server.
- MySQL can wait until level 02, but it doesn't hurt to have it on hand now if you installed Laragon.

## 🆘 Common issues

| Symptom | Likely cause | Solution |
|---|---|---|
| `php is not recognized as a command` | PHP is not in the `PATH` | Add the PHP folder to the system `PATH` and reopen the terminal |
| `composer is not recognized` | Composer poorly installed or PATH not reloaded | Reinstall, or restart the terminal |
| Missing extension (`Call to undefined function`) | PHP extension not enabled in `php.ini` | Uncomment the matching `extension=...` line in `php.ini`, then restart the server |

## ➡️ Going further

- Official PHP documentation: `php.net/manual/en/`
- Official Composer documentation: `getcomposer.org/doc/`
- [ressources/cheatsheets/](../../ressources/cheatsheets/) — cheatsheet of essential commands

---

**Next:** [00.3 — Git & GitHub Essentials](../03-git-github-essentiels/README.en.md)
