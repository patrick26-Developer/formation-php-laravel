# Exercises — 01.1 Syntax, Variables and Types

> Create one `.php` file per exercise in a personal working folder (e.g. `mon-parcours/01-1/`), run it with `php -S localhost:8000` or `php file-name.php`, then compare with [solutions/](solutions/README.en.md) only after trying.

## Exercise 1 — My ID card (easy)

Declare variables for your first name, age, city, and a boolean `estEtudiant`. Print a full sentence using all of them, with `echo` and variable interpolation.

**Expected result (example):**
```
My name is Alice, I'm 28 years old, I live in Lyon, and I'm a student: no
```

## Exercise 2 — Type inspector (easy)

Create 5 variables, one of each different scalar type (`int`, `float`, `string`, `bool`) plus an array. For each, print its type with `gettype()` then its content with `var_dump()`.

## Exercise 3 — Type conversions (medium)

Start from this variable:

```php
<?php
$saisieUtilisateur = "42.5abc";
```

1. Print its original type.
2. Convert it to `int` and print the result — what happens?
3. Convert it to `float` and print the result.
4. Explain in a comment the difference in behavior between the two conversions.

## Exercise 4 — Cart calculation (medium)

A customer buys 3 items at different prices. Declare three price variables (`float`), one `quantite` variable per item (`int`), and a `TVA_TAUX` constant set to 0.20. Calculate and print:

- The subtotal (sum of each price × its quantity)
- The tax amount
- The total including tax, rounded to 2 decimals with `round()`

## Exercise 5 — Bug detective (hard)

This code contains several syntax and logic errors related to this module's concepts. Fix them all and explain each fix in a comment.

```php
<?php

$Prix = 15.50
$quantite = "3"

$total = $prix * $quantite
echo 'Le total est : $total euros'
```

*(Hint: there are at least 4 distinct problems to fix.)*

---

Once done, compare your answers with [solutions/](solutions/README.en.md).
