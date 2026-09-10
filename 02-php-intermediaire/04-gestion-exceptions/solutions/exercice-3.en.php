<?php

declare(strict_types=1);

function traiterCommande(int $quantite, float $prix): float {
    if ($quantite <= 0) {
        throw new InvalidArgumentException("Quantity must be positive.");
    }

    if ($prix <= 0) {
        throw new RuntimeException("Price must be positive.");
    }

    return $quantite * $prix;
}

$cas = [
    ['quantite' => 3, 'prix' => 9.99],
    ['quantite' => -1, 'prix' => 9.99],
    ['quantite' => 3, 'prix' => -5.0],
];

foreach ($cas as $cas_) {
    try {
        $total = traiterCommande($cas_['quantite'], $cas_['prix']);
        echo "Total: " . round($total, 2) . " €\n";
    } catch (InvalidArgumentException $e) {
        echo "Quantity error: " . $e->getMessage() . "\n";
    } catch (RuntimeException $e) {
        echo "Price error: " . $e->getMessage() . "\n";
    }
}
