# 01.1 — Syntax, Variables and Types

> **Status:** ✅ Available

## 🎯 Objectives

- Write and run a valid PHP script.
- Declare variables and understand naming rules.
- Know PHP's data types and how to identify them.
- Understand dynamic typing and type conversion.

## 📋 Prerequisites

[Level 00 — Introduction](../../00-introduction/README.en.md) completed.

## ⏱️ Estimated duration

1h30 (theory + exercises).

## 📖 Theory

### The PHP tag

A PHP script is written between `<?php` and `?>`. In a purely PHP file (with no mixed HTML), the closing tag is usually omitted:

```php
<?php

echo "Hello world";
```

Every statement ends with a **semicolon** `;`. Forgetting it is the most common beginner mistake.

### Comments

```php
<?php

// Single-line comment

# Alternative single-line comment syntax

/*
   Comment
   spanning multiple lines
*/
```

### Variables

In PHP, a variable always starts with the `$` symbol, followed by a name:

```php
<?php

$firstName = "Alice";
$age = 28;
$isActive = true;
```

Naming rules:

- Must start with a letter or an underscore (`_`), never a digit.
- Can contain letters, digits, and underscores after the first character.
- **Case-sensitive**: `$name` and `$Name` are two different variables.
- This training's convention: `camelCase` for variables (`$dateOfBirth`, not `$date_of_birth`), except for arrays coming from a database, where `snake_case` may appear naturally.

### Dynamic typing

PHP is a **dynamically typed** language: you don't declare a variable's type when you create it — PHP infers it from the assigned value — and that type can change if you assign a different value later.

```php
<?php

$value = 10;      // $value is an integer (int)
$value = "ten";     // $value is now a string
```

> ⚠️ This behavior is convenient for beginners but can cause silent bugs in large projects. Modern PHP lets you add **strict types** (covered in detail in later modules on functions and OOP), a recommended practice in production.

### Scalar types

| Type | Example | Description |
|---|---|---|
| `int` | `$age = 28;` | Whole number |
| `float` | `$price = 19.99;` | Floating-point number |
| `string` | `$name = "Alice";` | Character string |
| `bool` | `$isActive = true;` | Boolean (`true` or `false`) |

### Compound types

| Type | Example | Description |
|---|---|---|
| `array` | `$fruits = ["apple", "pear"];` | Array (covered in detail in [module 01.5](../05-tableaux/README.md)) |
| `object` | class instance | Object (covered in detail in [level 02](../../02-php-intermediaire/README.md)) |

### Special types

| Type | Example | Description |
|---|---|---|
| `null` | `$value = null;` | Absence of a value |

### Checking and converting types

```php
<?php

$age = "28"; // string

var_dump($age);        // outputs: string(2) "28"
echo gettype($age);    // outputs: string

$ageAsInt = (int) $age; // explicit conversion (casting)
var_dump($ageAsInt);     // outputs: int(28)
```

Useful functions to test a type:

```php
<?php

is_int(28);       // true
is_string("28");  // true
is_bool(true);    // true
is_array([1, 2]); // true
is_null(null);    // true
```

### Displaying a value

Three common ways to display a value, each with different uses:

```php
<?php

$name = "Alice";

echo "Hello " . $name;           // echo: simple output, concatenation with .
echo "Hello $name";              // direct interpolation inside a double-quoted string
print_r(["a", "b", "c"]);        // print_r: to visualize the contents of an array or object
var_dump($name);                 // var_dump: also shows type and length, useful for debugging
```

> 📌 `echo` with **single** quotes (`'Hello $name'`) does not interpolate variables: the literal text `$name` will be displayed as-is. Use **double** quotes for interpolation.

### Constants

A constant cannot be changed after it is defined:

```php
<?php

define('VAT', 0.20);
// or, the recommended modern syntax:
const VAT_RATE = 0.20;

echo VAT_RATE; // no $ symbol for a constant
```

## 💡 Full example

```php
<?php

// Product information
$productName = "Mechanical keyboard";
$priceExclVat = 49.99;
const VAT = 0.20;

$priceInclVat = $priceExclVat * (1 + VAT);

echo "Product: $productName\n";
echo "Price incl. VAT: " . round($priceInclVat, 2) . "\n";
```

## ✅ Key takeaways

- Every PHP statement ends with `;`.
- A variable starts with `$`, is case-sensitive, and its type is inferred automatically.
- PHP has 4 scalar types (`int`, `float`, `string`, `bool`), arrays, objects, and `null`.
- `gettype()` and `var_dump()` are used to inspect a variable's actual type.
- Double quotes allow variable interpolation; single quotes do not.
- A constant (`const`) never changes value after it is defined.

## ➡️ Going further

- Official documentation: [php.net/manual/en/language.types.php](https://www.php.net/manual/en/language.types.php)
- [ressources/cheatsheets/php-cheatsheet.md](../../ressources/cheatsheets/) — cheatsheet of types and native functions

## 📝 Exercises

Now move on to [EXERCICES.md](EXERCICES.en.md) — **only check `solutions/` after attempting each exercise.**

---

**Previous:** [Level 00 — Introduction](../../00-introduction/README.en.md) · **Next:** [01.2 — Operators and Control Structures](../02-operateurs-structures-controle/README.en.md)
