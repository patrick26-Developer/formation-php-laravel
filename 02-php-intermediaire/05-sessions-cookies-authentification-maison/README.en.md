# 02.5 — Sessions, Cookies and Homemade Authentication

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the difference between a session and a cookie.
- Use `$_SESSION` to maintain state across multiple requests.
- Build a registration/login system with secure password hashing.
- Protect pages that require authentication.

## 📋 Prerequisites

[02.4 — Exception Handling](../04-gestion-exceptions/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Why does PHP need to "remember" the user?

HTTP is a **stateless** protocol: every request is entirely independent of the previous one. Without a specific mechanism, a server can't know whether two requests come from the same visitor. **Sessions** and **cookies** solve this problem.

| | Cookie | Session |
|---|---|---|
| Actual data storage | In the client's browser | On the server (the cookie only holds an identifier) |
| Visible/editable by the user | Yes | Not directly |
| Typical use case | Lightweight preferences, "remember me" | Sensitive data (logged-in user, cart) |

### Starting a session

```php
<?php
session_start(); // MUST be called before any HTML output, at the very start of the script

$_SESSION['visits'] = ($_SESSION['visits'] ?? 0) + 1;
echo "You have visited this page " . $_SESSION['visits'] . " times.";
```

PHP automatically sets a cookie (`PHPSESSID` by default) in the browser, which identifies the session on the server for every subsequent request.

### Handling cookies directly

```php
<?php
// setcookie(name, value, expiration, path, domain, https_only, http_only)
setcookie('theme', 'dark', time() + (86400 * 30), '/'); // expires in 30 days

echo $_COOKIE['theme'] ?? 'light'; // read (available starting from the NEXT request)
```

> ⚠️ `setcookie()` must be called **before any output** (like `session_start()`), because cookies are sent in HTTP headers, which must precede the response body.

### Hashing passwords correctly

**Never store a password in plain text.** PHP provides safe native functions to be used systematically.

```php
<?php
$password = "MyPassword123";

$hash = password_hash($password, PASSWORD_DEFAULT); // to be stored in the database
// $hash looks like: $2y$10$eImiTXuWVxfM37uY4JANjQ...

// To verify a password entered at login:
if (password_verify("MyPassword123", $hash)) {
    echo "Correct password";
}
```

> ⚠️ **This training's absolute rule, no exceptions**: every password is processed with `password_hash()` before storage, and checked with `password_verify()`. Never use `md5()` or `sha1()` for passwords (fast algorithms, therefore vulnerable to brute-force attacks — this topic is covered in [module 02.6](../06-securite-web-fondamentaux/README.en.md)).

### Building registration and login (simulation without a database)

For this module, we simulate a user "directory" in memory. Real database persistence arrives in [module 02.8](../08-pdo-bases-de-donnees-mysql/README.md).

```php
<?php
session_start();

// Simulates a user database (email => password hash)
$simulatedUsers = [
    'alice@example.com' => password_hash('secret123', PASSWORD_DEFAULT),
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($simulatedUsers[$email]) && password_verify($password, $simulatedUsers[$email])) {
        $_SESSION['user_email'] = $email; // mark the user as logged in
        header('Location: member-area.php');
        exit; // exit after header('Location: ...') is essential, otherwise the rest of the script keeps running
    }

    $error = "Incorrect email or password.";
}
```

### Protecting a page (homemade middleware)

```php
<?php
// member-area.php
session_start();

if (!isset($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}

echo "Welcome, " . htmlspecialchars($_SESSION['user_email']);
```

### Logging out

```php
<?php
session_start();
$_SESSION = []; // clears all session data
session_destroy(); // destroys the session on the server side
header('Location: login.php');
exit;
```

## ✅ Key takeaways

- `session_start()` must be called before any HTML content is sent.
- `$_SESSION` stores data server-side, identified by a cookie that holds only an identifier.
- `password_hash()`/`password_verify()`: the only acceptable way to handle passwords.
- `exit;` must always follow a `header('Location: ...')`.
- Protecting a page = checking `isset($_SESSION[...])` at the very start of the script, before any processing.

## ➡️ Going further

- [php.net/manual/en/book.session.php](https://www.php.net/manual/en/book.session.php)
- [php.net/manual/en/function.password-hash.php](https://www.php.net/manual/en/function.password-hash.php)
- [Module 02.6 — Web Security Fundamentals](../06-securite-web-fondamentaux/README.en.md)
- [Module 07.4 — Authentication with Breeze/Fortify](../../07-laravel-intermediaire/04-authentification-breeze-fortify/README.en.md) (how Laravel automates all of this)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [02.4 — Exception Handling](../04-gestion-exceptions/README.en.md) · **Next:** [02.6 — Web Security Fundamentals](../06-securite-web-fondamentaux/README.en.md)
