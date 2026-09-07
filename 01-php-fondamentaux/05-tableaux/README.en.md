# 01.5 — Arrays

> **Status:** ✅ Available

## 🎯 Objectives

- Create and manipulate indexed and associative arrays.
- Use the essential native functions (`array_map`, `array_filter`, `array_reduce`, sorting).
- Understand multidimensional arrays.

## 📋 Prerequisites

[01.4 — Functions and Variable Scope](../04-fonctions/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Indexed arrays

```php
<?php
$fruits = ["apple", "banana", "cherry"];

echo $fruits[0]; // apple
$fruits[] = "kiwi"; // append to the end
echo count($fruits); // 4
```

### Associative arrays

```php
<?php
$person = [
    "firstName" => "Alice",
    "age" => 28,
    "city" => "Lyon",
];

echo $person["firstName"]; // Alice
$person["email"] = "alice@example.com"; // add a key
```

### Multidimensional arrays

```php
<?php
$users = [
    ["firstName" => "Alice", "age" => 28],
    ["firstName" => "Bob", "age" => 35],
];

foreach ($users as $user) {
    echo $user["firstName"] . " is " . $user["age"] . " years old\n";
}
```

### Search and modification functions

```php
<?php
$numbers = [4, 8, 15, 16, 23, 42];

in_array(15, $numbers);        // true : does the value 15 exist?
array_search(15, $numbers);    // 2    : at which index?
array_key_exists(0, $numbers); // true : does key 0 exist?
count($numbers);               // 6
array_push($numbers, 100);     // append (equivalent to $numbers[] = 100)
array_pop($numbers);           // removes and returns the last element
```

### The functional trio: `array_map`, `array_filter`, `array_reduce`

These three functions let you transform arrays **without an explicit loop** — a style widely used in modern PHP and in Laravel (Collections, covered in level 06).

```php
<?php
$numbers = [1, 2, 3, 4, 5];

// array_map: applies a function to EVERY element, returns a new array of the same size
$doubled = array_map(fn(int $n): int => $n * 2, $numbers);
// [2, 4, 6, 8, 10]

// array_filter: keeps only the elements that satisfy a condition
$even = array_filter($numbers, fn(int $n): bool => $n % 2 === 0);
// [1 => 2, 3 => 4]  -- note: the original keys are preserved!

// array_reduce: reduces the array to a SINGLE value, by accumulating
$sum = array_reduce($numbers, fn(int $accumulator, int $n): int => $accumulator + $n, 0);
// 15
```

> ⚠️ `array_filter` preserves the original keys, which creates "gaps" in indexing. Use `array_values()` to cleanly reindex if needed: `array_values($even)`.

### Sorting an array

```php
<?php
$grades = [12, 5, 18, 9];

sort($grades);        // ascending sort, reindexes: [5, 9, 12, 18]
rsort($grades);         // descending sort

$person = ["b" => 2, "a" => 1];
ksort($person);          // sort by key: ["a" => 1, "b" => 2]
asort($person);          // sort by value, preserves keys
```

### Destructuring an array: `list()` / destructuring assignment

```php
<?php
$coordinates = [45.75, 4.85];
[$latitude, $longitude] = $coordinates;

echo "$latitude, $longitude"; // 45.75, 4.85
```

## ✅ Key takeaways

- A PHP array can be indexed (0, 1, 2...), associative (named keys), or a mix of both.
- `array_map`/`array_filter`/`array_reduce` advantageously replace many `foreach` loops.
- `array_filter` does not automatically reindex: remember `array_values()` if you need it.
- `sort()`/`rsort()` reindex, `asort()`/`ksort()` preserve keys.

## ➡️ Going further

- [php.net/manual/en/ref.array.php](https://www.php.net/manual/en/ref.array.php) — full list of array functions
- [ressources/cheatsheets/](../../ressources/cheatsheets/) — cheatsheet of the most useful array functions

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [01.4 — Functions and Variable Scope](../04-fonctions/README.en.md) · **Next:** [01.6 — Strings and Regex](../06-chaines-de-caracteres/README.en.md)
