# Exercises — 01.4 Functions and Variable Scope

## Exercise 1 — Basic functions (easy)

Write a typed function `estPair(int $nombre): bool` that returns `true` if the number is even. Test it with several values.

## Exercise 2 — Default values (easy)

Write a function `formaterPrix(float $prix, string $devise = "€"): string` that returns a string like `"19.99 €"`. Test it with and without the second argument.

## Exercise 3 — Variable scope (medium)

Without running the code, predict what it prints, then check:

```php
<?php
$compteur = 0;

function incrementer() {
    $compteur = $compteur + 1;
    return $compteur;
}

echo incrementer();
echo incrementer();
echo $compteur;
```

Explain in a comment why the result is what it is, then propose a corrected version that actually increments a shared counter (hint: the function must receive and return the value).

## Exercise 4 — `strict_types` in action (medium)

Create a file with `declare(strict_types=1);`, a function `diviser(int $a, int $b): float`, and call it once with valid integers, then once with a string (`diviser("10", 2)`). Observe and note the error you get.

## Exercise 5 — Arrow functions (hard)

Rewrite these three classic functions as arrow functions (`fn`):

```php
<?php
function estMajeur($age) { return $age >= 18; }
function carre($n) { return $n * $n; }
function concatener($a, $b) { return $a . $b; }
```

Then explain in a comment in which case an arrow function is **not** suitable (hint: several statements, needing a loop inside).

---

Compare with [solutions/](solutions/) once done.
