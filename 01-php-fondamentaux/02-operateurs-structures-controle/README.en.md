# 01.2 — Operators and Control Structures

> **Status:** ✅ Available

## 🎯 Objectives

- Know PHP's main operators (arithmetic, comparison, logical).
- Understand the difference between `==` and `===`.
- Write conditionals with `if`/`elseif`/`else`, `switch`, and `match`.

## 📋 Prerequisites

[01.1 — Syntax, Variables and Types](../01-syntaxe-variables-types/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### Arithmetic operators

```php
<?php
$a = 10;
$b = 3;

echo $a + $b;  // 13
echo $a - $b;  // 7
echo $a * $b;  // 30
echo $a / $b;  // 3.333...
echo $a % $b;  // 1  (modulo: remainder of the division)
echo $a ** $b; // 1000 (power)
```

### Comparison operators: `==` vs `===`

This is one of PHP's most classic pitfalls.

```php
<?php
var_dump(0 == "abc");   // false in PHP 8+ (before PHP 8, this was true!)
var_dump("10" == 10);   // true  : compares VALUES after type conversion
var_dump("10" === 10);  // false : also compares TYPE, string !== int
```

> ⚠️ **This training's rule: always prefer `===` and `!==`** unless you have a specific reason to want implicit conversion. It avoids silent bugs that are hard to track down.

| Operator | Name | Example | Result |
|---|---|---|---|
| `==` | "Loose" equality | `"5" == 5` | `true` |
| `===` | Strict equality | `"5" === 5` | `false` |
| `!=` / `<>` | Loose inequality | `5 != "5"` | `false` |
| `!==` | Strict inequality | `5 !== "5"` | `true` |
| `<`, `>`, `<=`, `>=` | Numeric comparisons | `5 > 3` | `true` |
| `<=>` | "Spaceship" operator | `5 <=> 3` | `1` (-1, 0, or 1) |

### Logical operators

```php
<?php
$isAdult = true;
$hasLicense = false;

var_dump($isAdult && $hasLicense); // logical AND: false
var_dump($isAdult || $hasLicense); // logical OR: true
var_dump(!$hasLicense);            // logical NOT: true
```

### The `if` / `elseif` / `else` conditional structure

```php
<?php
$grade = 14;

if ($grade >= 16) {
    echo "Excellent";
} elseif ($grade >= 12) {
    echo "Good";
} elseif ($grade >= 10) {
    echo "Passing";
} else {
    echo "Failing";
}
```

### The ternary operator and the null coalescing operator

```php
<?php
// Ternary: condition ? valueIfTrue : valueIfFalse
$status = $isAdult ? "adult" : "minor";

// Null coalescing (??): useful for potentially missing values
$username = $_GET['username'] ?? "Guest"; // if $_GET['username'] doesn't exist, use "Guest"
```

### `switch`

```php
<?php
$day = "wednesday";

switch ($day) {
    case "saturday":
    case "sunday":
        echo "Weekend";
        break;
    default:
        echo "Weekday";
        break;
}
```

> ⚠️ Never forget `break;`: without it, execution "falls through" into the next `case` (a deliberate PHP behavior called *fallthrough*, a source of bugs if not understood).

### `match` (PHP 8+, recommended modern syntax)

`match` advantageously replaces `switch` in most cases: **strict** comparison (`===`), no `break` needed, and it directly returns a value.

```php
<?php
$day = "wednesday";

$type = match ($day) {
    "saturday", "sunday" => "Weekend",
    default => "Weekday",
};

echo $type;
```

## ✅ Key takeaways

- Always prefer `===`/`!==` over `==`/`!=`.
- `&&`, `||`, `!` combine conditions.
- `match` (PHP 8+) is often preferable to `switch`: more concise, safer (strict comparison), and returns a value.
- The `??` operator avoids many verbose `isset()` checks for default values.

## ➡️ Going further

- [php.net/manual/en/language.operators.php](https://www.php.net/manual/en/language.operators.php)
- [php.net/manual/en/control-structures.match.php](https://www.php.net/manual/en/control-structures.match.php)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [01.1 — Syntax, Variables and Types](../01-syntaxe-variables-types/README.en.md) · **Next:** [01.3 — Loops](../03-boucles/README.en.md)
