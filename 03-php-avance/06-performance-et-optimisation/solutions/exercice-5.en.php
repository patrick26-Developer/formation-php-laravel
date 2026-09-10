<?php

declare(strict_types=1);

function fibonacci(int $n): int {
    if ($n <= 1) {
        return $n;
    }

    return fibonacci($n - 1) + fibonacci($n - 2);
}

function fibonacciMemoise(int $n, array &$cache = []): int {
    if ($n <= 1) {
        return $n;
    }

    // If already computed, return it directly instead of recomputing
    if (isset($cache[$n])) {
        return $cache[$n];
    }

    $resultat = fibonacciMemoise($n - 1, $cache) + fibonacciMemoise($n - 2, $cache);
    $cache[$n] = $resultat;

    return $resultat;
}

$debut1 = microtime(true);
$resultat1 = fibonacci(30);
$duree1 = microtime(true) - $debut1;

$debut2 = microtime(true);
$resultat2 = fibonacciMemoise(30);
$duree2 = microtime(true) - $debut2;

echo "Naive recursive: $resultat1 in " . round($duree1 * 1000, 2) . " ms\n";
echo "With memoization: $resultat2 in " . round($duree2 * 1000, 4) . " ms\n";

/*
 * The naive version recomputes the SAME sub-results MULTIPLE TIMES
 * (fibonacci(28) is recomputed thousands of times for fibonacci(30)),
 * with exponential complexity. Memoization stores every result already
 * computed and reuses it, bringing the complexity down to O(n) — the
 * performance gain is several orders of magnitude.
 */
