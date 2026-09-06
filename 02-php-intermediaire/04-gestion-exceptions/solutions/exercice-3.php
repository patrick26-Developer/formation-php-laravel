<?php

declare(strict_types=1);

function traiterCommande(int $quantite, float $prix): float {
    if ($quantite <= 0) {
        throw new InvalidArgumentException("La quantité doit être positive.");
    }

    if ($prix <= 0) {
        throw new RuntimeException("Le prix doit être positif.");
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
        echo "Total : " . round($total, 2) . " €\n";
    } catch (InvalidArgumentException $e) {
        echo "Erreur de quantité : " . $e->getMessage() . "\n";
    } catch (RuntimeException $e) {
        echo "Erreur de prix : " . $e->getMessage() . "\n";
    }
}
