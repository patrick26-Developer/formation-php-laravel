<?php

declare(strict_types=1);

$commandes = [
    ['id' => 1, 'client_id' => 1],
    ['id' => 2, 'client_id' => 2],
    ['id' => 3, 'client_id' => 1],
];
$clients = [1 => ['nom' => 'Alice'], 2 => ['nom' => 'Bob']];

// --- Version originale (N appels "coûteux") ---
// foreach ($commandes as $commande) {
//     $client = trouverClient($commande['client_id'], $clients); // usleep(1000) à chaque tour
//     echo "Commande {$commande['id']} pour {$client['nom']}\n";
// }

// --- Version corrigée : on accède directement au tableau $clients déjà
// disponible en mémoire, sans passer par un appel "coûteux" répété.
// (Dans un vrai cas avec une base de données, l'équivalent serait de
// charger TOUS les clients nécessaires en UNE requête avant la boucle,
// plutôt qu'une requête par commande — le problème N+1 du cours.)
foreach ($commandes as $commande) {
    $client = $clients[$commande['client_id']];
    echo "Commande {$commande['id']} pour {$client['nom']}\n";
}
