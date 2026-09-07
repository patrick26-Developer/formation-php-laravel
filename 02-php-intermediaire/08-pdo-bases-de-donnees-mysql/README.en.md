# 02.8 — PDO and MySQL Databases

> **Status:** ✅ Available

## 🎯 Objectives

- Connect to a MySQL database from PHP with PDO.
- Run prepared statements safely.
- Retrieve results in different forms.
- Handle database errors cleanly.

## 📋 Prerequisites

[02.7 — Composer, Autoloading, PSR](../07-composer-autoload-psr/README.en.md) and a MySQL/MariaDB database installed (see [00.2](../../00-introduction/02-installation-environnement/README.en.md)).

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Why PDO?

**PDO** (PHP Data Objects) is an abstraction layer for accessing databases in PHP. Unlike the older `mysqli` extension (tied exclusively to MySQL), PDO works with several database engines (MySQL, PostgreSQL, SQLite...) through a **single API**, and natively supports prepared statements — the protection against SQL injection covered in [module 02.6](../06-securite-web-fondamentaux/README.en.md).

### Connecting to MySQL

```php
<?php
declare(strict_types=1);

$host = '127.0.0.1';
$database = 'php_training';
$user = 'root';
$password = '';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$database;charset=utf8mb4",
        $user,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // throws exceptions on SQL errors
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // results as associative arrays
        ]
    );
} catch (PDOException $e) {
    die("Connection error: " . $e->getMessage());
}
```

> ⚠️ **Never** hardcode connection credentials in a version-controlled file. This module deliberately keeps things simple for learning purposes; [module 02.9](../09-crud-complet-pdo-tri-filtre-recherche/README.en.md) and later projects will use a separate, non-version-controlled configuration file (`.env`, see [00.3](../../00-introduction/03-git-github-essentiels/README.en.md)).

### Creating a table (SQL refresher, covered in depth in [level 04](../../04-bases-de-donnees-approfondi/README.md))

```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### INSERT with a prepared statement

```php
<?php
$stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
$stmt->execute([
    'name' => 'Alice Dupont',
    'email' => 'alice@example.com',
]);

$newId = $pdo->lastInsertId(); // retrieves the generated auto-increment ID
echo "User created with ID $newId";
```

### SELECT and retrieving results

```php
<?php
// Retrieve A SINGLE record
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => 1]);
$user = $stmt->fetch(); // an associative array, or false if no result

// Retrieve SEVERAL records
$stmt = $pdo->prepare("SELECT * FROM users WHERE name LIKE :search");
$stmt->execute(['search' => '%Dupont%']);
$users = $stmt->fetchAll(); // an array of associative arrays

foreach ($users as $user) {
    echo $user['name'] . " - " . $user['email'] . "\n";
}
```

### UPDATE and DELETE

```php
<?php
// UPDATE
$stmt = $pdo->prepare("UPDATE users SET name = :name WHERE id = :id");
$stmt->execute(['name' => 'Alice Martin', 'id' => 1]);
echo $stmt->rowCount() . " row(s) updated";

// DELETE
$stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
$stmt->execute(['id' => 1]);
echo $stmt->rowCount() . " row(s) deleted";
```

### Named vs positional placeholders

```php
<?php
// Named (recommended: more readable, especially with several parameters)
$stmt = $pdo->prepare("SELECT * FROM users WHERE name = :name AND email = :email");
$stmt->execute(['name' => 'Alice', 'email' => 'alice@example.com']);

// Positional (with ?)
$stmt = $pdo->prepare("SELECT * FROM users WHERE name = ? AND email = ?");
$stmt->execute(['Alice', 'alice@example.com']); // the order must match exactly
```

### Handling SQL errors

With `PDO::ERRMODE_EXCEPTION` configured on connection, any SQL error throws a `PDOException`, catchable like any exception (module 02.4):

```php
<?php
try {
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    $stmt->execute(['name' => 'Bob', 'email' => 'alice@example.com']); // email already used (UNIQUE)
} catch (PDOException $e) {
    echo "Error during creation: " . $e->getMessage();
    // In production, you would log $e rather than display the technical detail to the user
}
```

### Encapsulating the connection in a class (preparing for CRUD)

```php
<?php
declare(strict_types=1);

namespace App;

class Connection {
    private static ?\PDO $instance = null;

    public static function get(): \PDO {
        if (self::$instance === null) {
            self::$instance = new \PDO(
                "mysql:host=127.0.0.1;dbname=php_training;charset=utf8mb4",
                "root",
                "",
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                ]
            );
        }

        return self::$instance;
    }
}
```

> 📌 This Singleton pattern (covered in [module 02.3](../03-poo-avancee-traits-static-magic-methods/README.en.md)) avoids opening a new connection on every SQL query within the same script. It foreshadows the structure of this level's mini-project.

## ✅ Key takeaways

- Always configure `PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION` on connection.
- All user data goes through `execute()`, never concatenated into the SQL.
- `fetch()` for one result, `fetchAll()` for several.
- `lastInsertId()` after an `INSERT`, `rowCount()` after an `UPDATE`/`DELETE`.
- Encapsulating the connection in a dedicated class makes it easier to reuse throughout a project.

## ➡️ Going further

- [php.net/manual/en/book.pdo.php](https://www.php.net/manual/en/book.pdo.php)
- [Level 04 — Databases in Depth](../../04-bases-de-donnees-approfondi/README.en.md)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [02.7 — Composer, Autoloading, PSR](../07-composer-autoload-psr/README.en.md) · **Next:** [02.9 — Full CRUD with PDO](../09-crud-complet-pdo-tri-filtre-recherche/README.en.md)
