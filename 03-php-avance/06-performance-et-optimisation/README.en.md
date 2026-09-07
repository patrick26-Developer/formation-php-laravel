# 03.6 — PHP Performance and Optimization

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the value of OPcache.
- Identify the most common performance mistakes in PHP.
- Measure a script's execution time and memory usage.
- Optimize common queries and loops.

## 📋 Prerequisites

[03.5 — Best Practices, PSR-12, Clean Code](../05-bonnes-pratiques-psr-clean-code/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

> ⚠️ Golden rule of optimization: **measure before optimizing**. An optimization applied without prior measurement is often a waste of time, or even a readability regression for zero or negligible performance gain.

### Measuring time and memory

```php
<?php
$start = microtime(true);
$startMemory = memory_get_usage();

// ... code to measure ...
for ($i = 0; $i < 1_000_000; $i++) {
    $square = $i ** 2;
}

$duration = microtime(true) - $start;
$memoryUsed = memory_get_usage() - $startMemory;

echo "Duration: " . round($duration * 1000, 2) . " ms\n";
echo "Memory: " . round($memoryUsed / 1024, 2) . " KB\n";
```

### OPcache: speeding up execution in production

By default, PHP **recompiles** every script on every request (interpreting the source code into bytecode). **OPcache** caches this bytecode in memory, avoiding this recompilation on every request — a very significant performance gain in production.

```ini
; In php.ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.validate_timestamps=0 ; in production: doesn't check for modified files on every request (requires a cache restart/reset after deployment)
```

> ⚠️ `opcache.validate_timestamps=0` is a classic pitfall in development: if enabled, your code changes would never be picked up without manually clearing the cache. Reserve it for production, with a deployment process that clears the OPcache on every new release.

### Common performance mistakes

**1. SQL queries inside a loop (the "N+1" problem)**

```php
<?php
// ❌ One SQL query PER task: 1 query for the list + N additional queries
$tasks = $pdo->query("SELECT * FROM tasks")->fetchAll();
foreach ($tasks as $task) {
    $user = $pdo->query("SELECT * FROM users WHERE id = " . $task['user_id'])->fetch();
    echo $user['name'];
}

// ✅ A single additional query, with a join or an IN (...)
$tasks = $pdo->query(
    "SELECT tasks.*, users.name FROM tasks
     JOIN users ON users.id = tasks.user_id"
)->fetchAll();
```

> 📌 This problem, called the **N+1 problem**, is extremely common — including (especially!) with Eloquent in Laravel if you don't use *eager loading* (`with()`, covered in [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md)). Recognizing it now in native PHP will let you spot it immediately in Laravel.

**2. String concatenation in a loop over very large volumes**

```php
<?php
// Inefficient over a very large number of iterations
$result = '';
foreach ($millionsOfLines as $line) {
    $result .= $line . "\n";
}

// More efficient: accumulate into an array, join once at the end
$lines = [];
foreach ($millionsOfLines as $line) {
    $lines[] = $line;
}
$result = implode("\n", $lines);
```

**3. Loading all the data into memory when you only need a subset**

```php
<?php
// ❌ Loads ALL users into memory just to display 10 of them
$allUsers = $pdo->query("SELECT * FROM users")->fetchAll();
$firstTen = array_slice($allUsers, 0, 10);

// ✅ Only requests what's needed, directly from the database
$firstTen = $pdo->query("SELECT * FROM users LIMIT 10")->fetchAll();
```

### `isset()` rather than `array_key_exists()` when it's enough

```php
<?php
// isset() is slightly faster, but returns false if the value is null
isset($array['key']);

// array_key_exists() checks for the key's presence, even if its value is null
array_key_exists('key', $array);
```

For most cases (checking that a piece of data exists and isn't empty), `isset()` is enough and reads just as well.

## ✅ Key takeaways

- Always measure before optimizing: intuition about "what's slow" is often wrong.
- OPcache should be enabled in production, with `validate_timestamps=0` and a cache cleared on every deployment.
- The N+1 problem (one query per element of a list, inside a loop) is the most frequent and costly performance mistake.
- Only load into memory the data you actually need (`LIMIT`, pagination from module 02.9).

## ➡️ Going further

- [php.net/manual/en/book.opcache.php](https://www.php.net/manual/en/book.opcache.php)
- [Module 08.2 — Cache and Performance Optimization (Laravel)](../../08-laravel-avance/02-cache-optimisation-performance/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [03.5 — Best Practices, PSR-12, Clean Code](../05-bonnes-pratiques-psr-clean-code/README.en.md) · **Next:** [Large Project: MVC Mini-Framework with API](../grand-projet-01-mini-framework-mvc-avec-api/README.en.md)
