# 01.9 — Introduction to Error Handling

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the different levels of errors in PHP (notice, warning, fatal error).
- Use `try`/`catch` to handle a simple exception.
- Adopt first debugging reflexes.

## 📋 Prerequisites

[01.8 — Files, Includes and Organization](../08-fichiers-et-includes/README.en.md)

## ⏱️ Estimated duration

1h.

## 📖 Theory

### PHP error levels

| Level | Severity | Does the script continue? | Example |
|---|---|---|---|
| **Notice / Deprecated** | Low | Yes | Using a deprecated function |
| **Warning** | Medium | Yes | `include` of a missing file, division by zero (PHP 8+) |
| **Fatal error** | High | No, the script stops | Calling a non-existent function, strict type error |

In development, you should **always see every error**, even minor ones — they often reveal a bug that will become critical in production.

```php
<?php
// Place this at the top of your scripts during development
error_reporting(E_ALL);
ini_set('display_errors', '1');
```

> ⚠️ These settings are for **development only**. In production, errors are never displayed to the user (they can reveal sensitive information) — they are logged to a file instead. This topic is covered in detail in [module 11.5 — Monitoring and Logs](../../11-devops-docker-cicd-avance/05-monitoring-logs/README.md).

### Exceptions: `try` / `catch`

An **exception** is an object representing an error, which you can "catch" to react cleanly instead of letting the script crash.

```php
<?php
function divide(float $a, float $b): float {
    if ($b === 0.0) {
        throw new Exception("Cannot divide by zero.");
    }

    return $a / $b;
}

try {
    echo divide(10, 0);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

echo "The script continues normally after the catch.";
```

Breakdown:

- `throw new Exception(...)`: you "throw" an exception when an abnormal situation is detected.
- `try { ... }`: the "at-risk" block of code you're monitoring.
- `catch (Exception $e) { ... }`: the block run if an exception was thrown inside the `try`. `$e->getMessage()` retrieves the error message.

### `finally`: always runs

```php
<?php
try {
    echo "Attempting...\n";
    throw new Exception("Error!");
} catch (Exception $e) {
    echo "Caught error: " . $e->getMessage() . "\n";
} finally {
    echo "This block always runs, error or not.\n";
}
```

> 📌 This module only introduces exceptions. They are covered in depth (exception hierarchy, custom exceptions) in [module 02.4](../../02-php-intermediaire/04-gestion-exceptions/README.md), once object-oriented programming is mastered.

### First debugging reflexes

- **`var_dump()`** at a specific point in the code to inspect a variable.
- **`die()`** or **`exit()`** right after a `var_dump()` to stop execution and avoid being flooded by further output.
- Read the error message **in full**: PHP tells you the exact file and line of the problem.
- Isolate: comment out blocks of code to identify which one triggers the error.

```php
<?php
var_dump($suspiciousVariable);
die("Stopping for debugging");
```

## ✅ Key takeaways

- In development, always enable display of all errors (`error_reporting(E_ALL)`).
- An exception is thrown with `throw`, caught with `try`/`catch`.
- `finally` always runs, whether an exception was thrown or not.
- `var_dump()` + `die()` is the simplest and most commonly used debugging duo in daily work.

## ➡️ Going further

- [php.net/manual/en/language.exceptions.php](https://www.php.net/manual/en/language.exceptions.php)
- [Module 02.4 — Exception Handling (in depth)](../../02-php-intermediaire/04-gestion-exceptions/README.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [01.8 — Files, Includes and Organization](../08-fichiers-et-includes/README.en.md) · **Next:** [Mini-project: CLI and Web Calculator](../projet-mini-01-calculatrice-cli-et-web/README.md) *(French only)*
