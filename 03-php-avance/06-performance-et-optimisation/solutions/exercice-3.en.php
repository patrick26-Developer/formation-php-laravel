<?php

declare(strict_types=1);

$commandes = [
    ['id' => 1, 'client_id' => 1],
    ['id' => 2, 'client_id' => 2],
    ['id' => 3, 'client_id' => 1],
];
$clients = [1 => ['nom' => 'Alice'], 2 => ['nom' => 'Bob']];

// --- Original version (N "expensive" calls) ---
// foreach ($commandes as $commande) {
//     $client = trouverClient($commande['client_id'], $clients); // usleep(1000) on every loop
//     echo "Order {$commande['id']} for {$client['nom']}\n";
// }

// --- Fixed version: we access the $clients array already available in
// memory directly, without going through a repeated "expensive" call.
// (In a real case with a database, the equivalent would be to load ALL
// the needed clients in ONE query before the loop, rather than one
// query per order — the N+1 problem from the lesson.)
foreach ($commandes as $commande) {
    $client = $clients[$commande['client_id']];
    echo "Order {$commande['id']} for {$client['nom']}\n";
}
