# 01.8 — Files, Includes and Code Organization

> **Status:** ✅ Available

## 🎯 Objectives

- Read and write text files with PHP.
- Use `include`, `require`, and their `_once` variants.
- Organize a PHP project across multiple files consistently.

## 📋 Prerequisites

[01.7 — HTML Forms and GET/POST](../07-formulaires-http-get-post/README.en.md)

## ⏱️ Estimated duration

1h.

## 📖 Theory

### Reading a file

```php
<?php
$content = file_get_contents("notes.txt"); // the whole file as a single string
echo $content;

$lines = file("notes.txt"); // an array, one entry per line
foreach ($lines as $line) {
    echo trim($line) . "\n";
}
```

### Writing to a file

```php
<?php
file_put_contents("notes.txt", "New line\n"); // overwrites existing content
file_put_contents("notes.txt", "Appended line\n", FILE_APPEND); // appends to the end
```

### Checking existence and handling paths

```php
<?php
if (file_exists("notes.txt")) {
    echo "The file exists.";
}

// __DIR__ : the folder of the currently executing PHP file (absolute path)
$absolutePath = __DIR__ . "/notes.txt";
```

> ⚠️ Always use `__DIR__` to build paths to other files in your project rather than relative paths like `"../notes.txt"`. A relative path depends on the folder the script was launched from, which breaks easily as soon as the file is included from elsewhere.

### `include` vs `require`

```php
<?php
include "config.php";   // if the file doesn't exist: warning, the script continues
require "config.php";   // if the file doesn't exist: fatal error, the script stops
```

> 📌 This training's rule: use **`require`** for any file essential to the application working (configuration, functions used afterward). Reserve `include` for cases where the file's absence isn't blocking (an optional section of a page, for example).

### `_once`: avoiding multiple inclusions

```php
<?php
require_once "functions.php"; // includes the file only once, even if called multiple times
```

Without `_once`, including a file that declares a function twice would cause a fatal error ("Cannot redeclare function"). **`require_once` is the default standard** to use for any declarations file (functions, classes, configuration).

### Organizing a small multi-file project

Typical structure of a small PHP project without a framework:

```
my-project/
├── config.php        # constants, settings
├── functions.php       # reusable functions
├── index.php            # entry point
└── partials/
    ├── header.php
    └── footer.php
```

`functions.php`:
```php
<?php

function formatPrice(float $price): string {
    return number_format($price, 2) . " $";
}
```

`index.php`:
```php
<?php
require_once __DIR__ . "/functions.php";

$price = 19.9;
echo formatPrice($price); // 19.90 $
```

> 📌 This manual `require_once`-based organization is deliberately basic: it helps you understand the inclusion mechanism before discovering **autoloading** with Composer in [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md), which fully automates file loading in any modern PHP project (and in Laravel).

## ✅ Key takeaways

- `require_once` is the default choice for including declaration files.
- `__DIR__` avoids fragile relative-path problems.
- `file_get_contents`/`file_put_contents` are enough for simple text file operations.
- Separating configuration, functions, and entry point is the first step toward a clean architecture.

## ➡️ Going further

- [php.net/manual/en/function.require-once.php](https://www.php.net/manual/en/function.require-once.php)
- [Module 02.7 — Composer, Autoloading, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [01.7 — HTML Forms and GET/POST](../07-formulaires-http-get-post/README.en.md) · **Next:** [01.9 — Introduction to Error Handling](../09-gestion-erreurs-debutant/README.en.md)
