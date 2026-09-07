# 01.4 — Functions and Variable Scope

> **Status:** ✅ Available

## 🎯 Objectives

- Declare and call functions.
- Use parameters, default values, and types.
- Understand return values and variable scope.
- Use arrow functions.

## 📋 Prerequisites

[01.3 — Loops](../03-boucles/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Declaring a function

```php
<?php
function greet($name) {
    echo "Hello $name!";
}

greet("Alice"); // Hello Alice!
```

### Parameters with a default value

```php
<?php
function greet($name, $greeting = "Hello") {
    echo "$greeting $name!";
}

greet("Bob");                 // Hello Bob!
greet("Claire", "Good evening"); // Good evening Claire!
```

### Typing parameters and the return value (modern PHP)

Since PHP 7+, you can (and **should**) declare the types of parameters and the returned value. This is a strongly recommended practice throughout this training, even outside Laravel.

```php
<?php
function add(int $a, int $b): int {
    return $a + $b;
}

echo add(2, 3); // 5
```

If you pass an incompatible type (`add("abc", 3)`), PHP throws a `TypeError` — which is **intentional**: an immediate, explicit error is better than a silent bug later on.

### `declare(strict_types=1)`

By default, PHP tries to automatically convert types passed to a typed function ("coercive" mode). To force strict checking, add this line **at the very top of the file**:

```php
<?php
declare(strict_types=1);

function add(int $a, int $b): int {
    return $a + $b;
}

add("2", 3); // TypeError: without strict_types, "2" would have been silently converted to 2
```

> 📌 This training's convention: `declare(strict_types=1)` will be used systematically starting at level 02, as soon as we write object-oriented code.

### `return` and early exit

```php
<?php
function isAdult(int $age): bool {
    if ($age < 0) {
        return false; // early exit for an invalid case
    }

    return $age >= 18;
}
```

A function stops **immediately** as soon as it hits a `return`.

### Variable scope

A variable declared inside a function exists **only** within that function:

```php
<?php
function calculateSquare(int $number): int {
    $result = $number * $number; // $result only exists inside this function
    return $result;
}

calculateSquare(4);
echo $result; // Error: $result is not defined here (out of scope)
```

Conversely, a function does **not** have access to variables declared outside it, except through its parameters:

```php
<?php
$multiplier = 10;

function multiply(int $number): int {
    // $multiplier is NOT accessible here, even though it exists "above"
    return $number * 2; // required values must be passed as parameters
}
```

### Arrow functions (PHP 7.4+)

Useful for short functions, often passed as arguments to other functions (see `array_map` in the next module):

```php
<?php
$double = fn(int $n): int => $n * 2;

echo $double(5); // 10
```

## ✅ Key takeaways

- Typing a function's parameters and return value is a good practice to adopt right away.
- `declare(strict_types=1)` prevents silent type conversions.
- A variable local to a function does not exist outside it, and vice versa.
- Arrow functions (`fn() => ...`) are handy for short, functional-style code.

## ➡️ Going further

- [php.net/manual/en/functions.arguments.php](https://www.php.net/manual/en/functions.arguments.php)
- [php.net/manual/en/language.types.declarations.php](https://www.php.net/manual/en/language.types.declarations.php)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [01.3 — Loops](../03-boucles/README.en.md) · **Next:** [01.5 — Arrays](../05-tableaux/README.en.md)
