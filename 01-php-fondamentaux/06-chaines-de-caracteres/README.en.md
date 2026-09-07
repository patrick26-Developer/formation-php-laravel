# 01.6 — Strings and Regular Expressions

> **Status:** ✅ Available

## 🎯 Objectives

- Manipulate strings with the essential native functions.
- Format and transform text.
- Use basic regular expressions (`preg_match`, `preg_replace`).

## 📋 Prerequisites

[01.5 — Arrays](../05-tableaux/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### Basic string functions

```php
<?php
$text = "Hello world";

strlen($text);            // 11 : length in bytes
strtoupper($text);        // "HELLO WORLD"
strtolower($text);        // "hello world"
ucfirst("hello");         // "Hello" : capitalizes the first letter
ucwords("hello world");   // "Hello World" : capitalizes each word

str_contains($text, "world");  // true (PHP 8+)
str_starts_with($text, "Hel"); // true (PHP 8+)
str_ends_with($text, "world"); // true (PHP 8+)

substr($text, 0, 5);       // "Hello" : substring (start, length)
str_replace("world", "PHP", $text); // "Hello PHP"

trim("  spaces around  "); // "spaces around" : removes leading/trailing spaces
```

> 📌 Before PHP 8, you had to use `strpos($text, "world") !== false` to test for presence. `str_contains()` is more readable and avoids a classic pitfall (`strpos` can return `0`, which is "falsy" yet still means "found at position 0").

### Splitting and joining

```php
<?php
$sentence = "apple,banana,cherry";

$fruits = explode(",", $sentence); // ["apple", "banana", "cherry"]
$joined = implode(" - ", $fruits); // "apple - banana - cherry"
```

### Interpolation and advanced formatting

```php
<?php
$name = "Alice";
$age = 28;

// sprintf: precise formatting, especially for aligning numbers
$sentence = sprintf("%s is %d years old", $name, $age);
$formattedPrice = sprintf("$%.2f", 19.5); // "$19.50"

// "Heredoc" syntax: for long blocks of text with interpolation
$message = <<<TEXT
Hello $name,
You are $age years old.
TEXT;
```

### Regular expressions (regex) with PCRE

PHP uses PCRE syntax (Perl Compatible Regular Expressions), delimited by a character (usually `/`):

```php
<?php
$email = "alice@example.com";

// preg_match: tests whether the pattern matches, returns 1 (found) or 0
if (preg_match('/^[\w.+-]+@[\w-]+\.[a-z]{2,}$/i', $email)) {
    echo "Valid email (format)";
}

// preg_replace: replaces all occurrences matching the pattern
$cleanedText = preg_replace('/[0-9]/', '', "Code2024Postal"); // "CodePostal"

// preg_match_all: captures every match
preg_match_all('/\d+/', "I have 3 cats and 12 fish", $numbers);
print_r($numbers[0]); // ["3", "12"]
```

> ⚠️ A regex checks a **format**, not real-world validity. `preg_match` on an email checks that the string *looks like* an email, but doesn't guarantee it exists. For real email validation in PHP, use `filter_var($email, FILTER_VALIDATE_EMAIL)` instead (covered in [module 01.7](../07-formulaires-http-get-post/README.en.md)).

## ✅ Key takeaways

- `str_contains`, `str_starts_with`, `str_ends_with` (PHP 8+) are more readable than `strpos`.
- `explode`/`implode` to go from a string to an array and back.
- `sprintf` for precise formatting (rounding, alignment).
- Regexes check **formats**; `filter_var` is often preferable for validating real-world data (email, URL...).

## ➡️ Going further

- [php.net/manual/en/ref.strings.php](https://www.php.net/manual/en/ref.strings.php)
- [regex101.com](https://regex101.com) — test your regular expressions interactively (choose the "PCRE2" flavor)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [01.5 — Arrays](../05-tableaux/README.en.md) · **Next:** [01.7 — HTML Forms and GET/POST](../07-formulaires-http-get-post/README.en.md)
