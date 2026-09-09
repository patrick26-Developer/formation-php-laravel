# Exercises — 03.6 PHP Performance and Optimization

## Exercise 1 — Measuring a script (easy)

Write a script that measures and prints the execution time of a loop calculating the sum of squares from 1 to 5,000,000.

## Exercise 2 — Comparing two approaches (easy)

Compare the execution time of string concatenation in a loop (`.=`) against accumulating into an array + `implode()`, over 100,000 elements. Print both measured durations.

## Exercise 3 — Spotting an N+1 problem (medium)

This code simulates an N+1 problem with plain PHP arrays (no real database needed):

```php
<?php
$commandes = [
    ['id' => 1, 'client_id' => 1],
    ['id' => 2, 'client_id' => 2],
    ['id' => 3, 'client_id' => 1],
];
$clients = [1 => ['nom' => 'Alice'], 2 => ['nom' => 'Bob']];

function trouverClient(int $id, array $clients): array {
    // simulates an expensive "query" on every call
    usleep(1000);
    return $clients[$id];
}

foreach ($commandes as $commande) {
    $client = trouverClient($commande['client_id'], $clients);
    echo "Commande {$commande['id']} pour {$client['nom']}\n";
}
```

Rewrite it to eliminate the repeated call to `trouverClient()` inside the loop (hint: the function is already called with a complete `$clients` array — use it directly).

## Exercise 4 — Pagination vs. full load (medium)

With an array of 10,000 generated elements (`range(1, 10000)`), compare the time taken by `array_slice($tableau, 9990, 10)` against a `foreach` loop that walks the whole array to keep only the last 10 elements. Conclude in a comment on which approach to prefer.

## Exercise 5 — Profiling a naive recursive function (hard)

The Fibonacci sequence calculated with naive recursion is a classic performance offender:

```php
<?php
function fibonacci(int $n): int {
    if ($n <= 1) return $n;
    return fibonacci($n - 1) + fibonacci($n - 2);
}
```

Measure the time for `fibonacci(30)`. Then write a version with **memoization** (caching already-computed results in an array) and compare the two durations.

---

Compare with [solutions/](solutions/README.en.md) once done.
