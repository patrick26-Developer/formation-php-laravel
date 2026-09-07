# 01.3 — Loops

> **Status:** ✅ Available

## 🎯 Objectives

- Repeat a block of statements with `for`, `while`, `do-while`, and `foreach`.
- Know when to use each type of loop.
- Master `break` and `continue`.

## 📋 Prerequisites

[01.2 — Operators and Control Structures](../02-operateurs-structures-controle/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### `for` — when you know the number of iterations

```php
<?php
for ($i = 0; $i < 5; $i++) {
    echo "Iteration $i\n";
}
```

Structure: `for (initialization; condition; increment) { ... }`.

### `while` — as long as a condition is true

```php
<?php
$i = 0;
while ($i < 5) {
    echo "Iteration $i\n";
    $i++;
}
```

> ⚠️ Classic pitfall: forgetting `$i++` inside the loop body creates an **infinite loop**.

### `do-while` — runs at least once

```php
<?php
$i = 0;
do {
    echo "Iteration $i\n";
    $i++;
} while ($i < 5);
```

The difference from `while`: the condition is checked **after** the first pass, so the block always runs at least once, even if the condition is false from the start.

### `foreach` — for iterating over an array (the most used loop in PHP)

```php
<?php
$fruits = ["apple", "banana", "cherry"];

foreach ($fruits as $fruit) {
    echo "$fruit\n";
}

// With the key (index) in addition to the value
foreach ($fruits as $index => $fruit) {
    echo "$index: $fruit\n";
}

// On an associative array
$ages = ["Alice" => 28, "Bob" => 35];
foreach ($ages as $name => $age) {
    echo "$name is $age years old\n";
}
```

> 📌 `foreach` will be your default loop as soon as you work with arrays (next module) or database results (level 02). `for`/`while` loops remain useful for counter-based logic or conditions that don't directly depend on an array.

### `break` and `continue`

```php
<?php
for ($i = 0; $i < 10; $i++) {
    if ($i === 3) {
        continue; // skips to the next iteration without running the rest of the block
    }
    if ($i === 7) {
        break; // stops the loop entirely
    }
    echo "$i ";
}
// Outputs: 0 1 2 4 5 6
```

### Nested loops

```php
<?php
for ($row = 1; $row <= 3; $row++) {
    for ($col = 1; $col <= 3; $col++) {
        echo "($row,$col) ";
    }
    echo "\n";
}
```

## ✅ Key takeaways

- `for`: number of iterations known in advance.
- `while`: repeats as long as a condition is true (0 to n times).
- `do-while`: like `while`, but guarantees at least one pass.
- `foreach`: the idiomatic loop for iterating over an array in PHP.
- `continue` skips to the next iteration, `break` stops the loop.

## ➡️ Going further

- [php.net/manual/en/control-structures.foreach.php](https://www.php.net/manual/en/control-structures.foreach.php)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [01.2 — Operators and Control Structures](../02-operateurs-structures-controle/README.en.md) · **Next:** [01.4 — Functions and Variable Scope](../04-fonctions/README.en.md)
