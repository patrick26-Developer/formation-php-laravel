# 02.7 — Composer, Autoloading and PSR Standards

> **Status:** ✅ Available

## 🎯 Objectives

- Understand Composer's role in the PHP ecosystem.
- Install and use an external dependency.
- Understand and configure PSR-4 autoloading.
- Know the essential PSR standards to follow.

## 📋 Prerequisites

[02.6 — Web Security Fundamentals](../06-securite-web-fondamentaux/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### What is Composer?

Composer is the reference **dependency manager** for PHP. It lets you install third-party libraries (like `npm` for Node.js or `pip` for Python), and — just as important — manage **autoloading** for your own classes. **Laravel and nearly the entire modern PHP ecosystem run on Composer.**

### Initializing a project with Composer

```bash
composer init
```

This command creates an interactive `composer.json` file, describing your project and its dependencies. A minimal example:

```json
{
    "name": "your-name/my-project",
    "require": {
        "php": ">=8.3"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
```

### Installing a dependency

```bash
composer require monolog/monolog
```

This command downloads the library into a `vendor/` folder (**never** version-controlled in Git — see [00.3](../../00-introduction/03-git-github-essentiels/README.en.md)) and updates `composer.json` and `composer.lock` (the latter pins the exact installed versions, and IS version-controlled, to guarantee the whole team uses the same versions).

```bash
composer install    # installs the dependencies listed in composer.json/composer.lock
composer update      # updates dependencies to their latest compatible versions
```

> 📌 `composer install` is the command you'll use most often: starting now, in **every** project in this training, it will be the "install dependencies" step described in each project's `INSTALLATION.md` file.

### PSR-4 autoloading: the end of manual `require_once`

Until now (module 01.8), you've included your files manually with `require_once`. With Composer, a single `require` of the autoload file is enough for **your entire project**.

A PSR-4-compliant folder structure:

```
my-project/
├── composer.json
├── src/
│   ├── Calculator.php     # namespace App;  class Calculator
│   └── User.php             # namespace App;  class User
└── index.php
```

`src/Calculator.php`:
```php
<?php
declare(strict_types=1);

namespace App;

class Calculator {
    public function add(int $a, int $b): int {
        return $a + $b;
    }
}
```

`index.php`:
```php
<?php
require __DIR__ . '/vendor/autoload.php'; // the ONLY require needed for the entire project

use App\Calculator;

$calculator = new Calculator();
echo $calculator->add(2, 3);
```

After any change to the namespace/folder mapping, regenerate the autoload file:

```bash
composer dump-autoload
```

> 📌 The PSR-4 principle: the `App\` namespace maps to the `src/` folder. A class `App\Services\SendEmail` must therefore live at `src/Services/SendEmail.php`. Composer uses this convention to automatically locate and load the right class, with no manual `require`.

### PSR standards: why follow them?

**PSR** (PHP Standards Recommendations) is a set of recommendations established by **PHP-FIG**, a group representing the major PHP frameworks and projects (including Laravel, Symfony...). Following them ensures your code integrates naturally with the rest of the ecosystem.

| Standard | Subject |
|---|---|
| **PSR-1** | Basic rules (UTF-8 encoding, `<?php` tags, class names in `PascalCase`...) |
| **PSR-4** | Autoloading convention (shown above) |
| **PSR-12** | Detailed code style (indentation, brace placement, spacing) — covered in depth in [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md) |

## ✅ Key takeaways

- `composer install` installs a project's dependencies from its `composer.json`/`composer.lock`.
- `vendor/` is never version-controlled; `composer.lock` always is.
- PSR-4 maps a namespace to a folder, enabling automatic autoloading via `vendor/autoload.php`.
- Following PSR standards makes your code compatible with the modern PHP ecosystem, Laravel included.

## ➡️ Going further

- [getcomposer.org/doc/](https://getcomposer.org/doc/)
- [php-fig.org/psr/](https://www.php-fig.org/psr/) — full list of PSR standards

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [02.6 — Web Security Fundamentals](../06-securite-web-fondamentaux/README.en.md) · **Next:** [02.8 — PDO and MySQL](../08-pdo-bases-de-donnees-mysql/README.en.md)
