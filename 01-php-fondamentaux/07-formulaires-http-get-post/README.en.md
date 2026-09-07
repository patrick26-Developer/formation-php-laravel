# 01.7 — HTML Forms and GET/POST Requests

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the difference between the `GET` and `POST` HTTP methods.
- Create an HTML form and process its data in PHP.
- Validate and sanitize data received from a user.
- Guard against the first form-related security flaws (basic XSS).

## 📋 Prerequisites

[01.6 — Strings and Regex](../06-chaines-de-caracteres/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### GET vs POST: what's the difference?

| | `GET` | `POST` |
|---|---|---|
| Where is the data? | In the URL (`?name=Alice&age=28`) | In the request body (invisible in the URL) |
| Visible/shareable? | Yes (bookmarks, history) | No |
| Size limited? | Yes (a few KB depending on browsers) | No (or very large) |
| Typical use case | Search, filters, pagination | Login, sign-up, sending sensitive or large data |

### A simple HTML form

```html
<form action="process.php" method="POST">
    <label for="firstName">First name:</label>
    <input type="text" id="firstName" name="firstName" required>

    <label for="age">Age:</label>
    <input type="number" id="age" name="age" required>

    <button type="submit">Send</button>
</form>
```

The `name` attribute of each field is the **key** under which PHP will receive the value.

### Retrieving data on the PHP side

```php
<?php
// process.php

$firstName = $_POST['firstName'] ?? null;
$age = $_POST['age'] ?? null;

if ($firstName === null || $age === null) {
    echo "Missing data.";
    exit;
}

echo "Hello $firstName, you are $age years old.";
```

> 📌 We systematically use `?? null` (or a default value) rather than accessing `$_POST['firstName']` directly, because if the field is absent, PHP raises a warning ("Undefined array key").

For a `GET` form, `$_GET` is used the same way. `$_REQUEST` combines `$_GET`, `$_POST`, and `$_COOKIE`, but **its use is discouraged** in this training: it's ambiguous about the actual origin of the data.

### Validating received data

**Never trust** data sent by a user, even through a form you created yourself (a malicious user can send a request directly, bypassing your form entirely).

```php
<?php
$age = $_POST['age'] ?? '';

if (!is_numeric($age)) {
    echo "Age must be a number.";
    exit;
}

$age = (int) $age;

if ($age < 0 || $age > 150) {
    echo "Invalid age.";
    exit;
}
```

For an email, `filter_var()` is the recommended tool:

```php
<?php
$email = $_POST['email'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email.";
    exit;
}
```

### Guarding against XSS when displaying data

If you **redisplay** data entered by the user in an HTML page, you must escape it with `htmlspecialchars()`, otherwise a malicious user could inject HTML/JavaScript code (an XSS flaw — covered in depth in [module 02.6](../../02-php-intermediaire/06-securite-web-fondamentaux/README.md)).

```php
<?php
$comment = $_POST['comment'] ?? '';

// Without protection: if $comment contains "<script>alert('hacked')</script>",
// that script would run in the browser of every visitor to the page!
echo "<p>" . htmlspecialchars($comment) . "</p>";
```

> ⚠️ Learn this reflex now: **any user data redisplayed as HTML goes through `htmlspecialchars()`**. This is one of the most important security rules in this entire path.

## 💡 Complete example: form + processing

`form.html`:
```html
<form action="index.php" method="POST">
    <input type="text" name="firstName" placeholder="Your first name" required>
    <input type="email" name="email" placeholder="Your email" required>
    <button type="submit">Send</button>
</form>
```

`index.php`:
```php
<?php
$errors = [];
$firstName = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($firstName === '') {
        $errors[] = "First name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid.";
    }

    if (empty($errors)) {
        echo "Thank you " . htmlspecialchars($firstName) . ", we received your email.";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<body>
    <?php foreach ($errors as $error): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endforeach; ?>

    <form action="index.php" method="POST">
        <input type="text" name="firstName" value="<?= htmlspecialchars($firstName) ?>" placeholder="Your first name">
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="Your email">
        <button type="submit">Send</button>
    </form>
</body>
</html>
```

> 📌 `<?= $variable ?>` is a shorthand for `<?php echo $variable; ?>`, widely used when mixing PHP and HTML.

## ✅ Key takeaways

- `GET` for visible/light data (search, filters), `POST` for sensitive or large data.
- Always use `?? defaultValue` to access `$_GET`/`$_POST`.
- Never trust user data: always validate it before use.
- Always run user data through `htmlspecialchars()` before redisplaying it as HTML.
- `filter_var($value, FILTER_VALIDATE_EMAIL)` to validate an email.

## ➡️ Going further

- [php.net/manual/en/reserved.variables.post.php](https://www.php.net/manual/en/reserved.variables.post.php)
- [Level 02.6 — Web Security Fundamentals](../../02-php-intermediaire/06-securite-web-fondamentaux/README.md) (XSS, CSRF, SQL injection in detail)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [01.6 — Strings and Regex](../06-chaines-de-caracteres/README.en.md) · **Next:** [01.8 — Files, Includes and Organization](../08-fichiers-et-includes/README.en.md)
