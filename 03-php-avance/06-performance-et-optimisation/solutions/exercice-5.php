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

    // Si déjà calculé, on le retourne directement au lieu de recalculer
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

echo "Récursif naïf : $resultat1 en " . round($duree1 * 1000, 2) . " ms\n";
echo "Avec mémoïsation : $resultat2 en " . round($duree2 * 1000, 4) . " ms\n";

/*
 * La version naïve recalcule PLUSIEURS FOIS les mêmes sous-résultats
 * (fibonacci(28) est recalculé des milliers de fois pour fibonacci(30)),
 * avec une complexité exponentielle. La mémoïsation stocke chaque résultat
 * déjà calculé et le réutilise, ramenant la complexité à O(n) — le gain
 * de performance est de plusieurs ordres de grandeur.
 */
