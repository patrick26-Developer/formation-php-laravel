# Exercises — 01.2 Operators and Control Structures

## Exercise 1 — Tricky comparisons (easy)

Predict the result of each `var_dump` below **before** running it, write down your predictions in a comment, then check:

```php
<?php
var_dump("0" == false);
var_dump("" == null);
var_dump("abc" == 0);
var_dump(1 === 1.0);
var_dump(null == false);
```

## Exercise 2 — Age category (easy)

Write a script that declares `$age`, then prints "Child" (< 13), "Teenager" (13-17), "Adult" (18-64), or "Senior" (65+) depending on the value. Use `if`/`elseif`/`else`.

## Exercise 3 — The same exercise with `match` (medium)

Rewrite exercise 2 using `match` with boolean conditions (`match(true)`). Compare readability with the `if`/`elseif` version.

## Exercise 4 — Simple password validator (medium)

A password is valid if it's at least 8 characters long **AND** contains at least one digit. Use `strlen()` and a simple regular expression (`preg_match('/[0-9]/', $motDePasse)`) combined with the `&&` operator. Print "valid" or "invalid".

## Exercise 5 — Restaurant menu with `switch` (hard)

Simulate a menu where `$plat` can be `"entree"`, `"plat"`, `"dessert"`, or something else. Use `switch` to print the matching price (starter: €5, main: €12, dessert: €4, otherwise: "unknown dish"). Deliberately forget a `break` on one case, observe the *fallthrough* behavior, then fix it.

---

Compare with [solutions/](solutions/) once done.
