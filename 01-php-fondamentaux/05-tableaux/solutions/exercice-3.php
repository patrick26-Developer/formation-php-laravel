<?php

$prix = [19.99, 5.50, 120.00, 8.75, 45.00];

// Étape par étape
$prixTTC = array_map(fn(float $p): float => round($p * 1.20, 2), $prix);
$prixTTCFiltres = array_filter($prixTTC, fn(float $p): bool => $p > 10);
$total = array_reduce($prixTTCFiltres, fn(float $acc, float $p): float => $acc + $p, 0.0);

echo "Prix TTC : " . implode(", ", $prixTTC) . "\n";
echo "Prix TTC > 10€ : " . implode(", ", $prixTTCFiltres) . "\n";
echo "Total : " . round($total, 2) . " €\n";

// En une seule chaîne d'appels
$totalEnChaine = array_reduce(
    array_filter(
        array_map(fn(float $p): float => round($p * 1.20, 2), $prix),
        fn(float $p): bool => $p > 10
    ),
    fn(float $acc, float $p): float => $acc + $p,
    0.0
);

echo "Total (chaîné) : " . round($totalEnChaine, 2) . " €\n";
