<?php

$prix = [19.99, 5.50, 120.00, 8.75, 45.00];

// Step by step
$prixTTC = array_map(fn(float $p): float => round($p * 1.20, 2), $prix);
$prixTTCFiltres = array_filter($prixTTC, fn(float $p): bool => $p > 10);
$total = array_reduce($prixTTCFiltres, fn(float $acc, float $p): float => $acc + $p, 0.0);

echo "Prices incl. VAT: " . implode(", ", $prixTTC) . "\n";
echo "Prices incl. VAT > €10: " . implode(", ", $prixTTCFiltres) . "\n";
echo "Total: " . round($total, 2) . " €\n";

// As a single chain of calls
$totalEnChaine = array_reduce(
    array_filter(
        array_map(fn(float $p): float => round($p * 1.20, 2), $prix),
        fn(float $p): bool => $p > 10
    ),
    fn(float $acc, float $p): float => $acc + $p,
    0.0
);

echo "Total (chained): " . round($totalEnChaine, 2) . " €\n";
