<?php

declare(strict_types=1);

$n = 100_000;

// Approche 1 : concaténation directe
$debut1 = microtime(true);
$resultat1 = '';
for ($i = 0; $i < $n; $i++) {
    $resultat1 .= "ligne $i\n";
}
$duree1 = microtime(true) - $debut1;

// Approche 2 : accumulation dans un tableau puis implode() une seule fois
$debut2 = microtime(true);
$lignes = [];
for ($i = 0; $i < $n; $i++) {
    $lignes[] = "ligne $i";
}
$resultat2 = implode("\n", $lignes);
$duree2 = microtime(true) - $debut2;

echo "Concaténation directe : " . round($duree1 * 1000, 2) . " ms\n";
echo "Tableau + implode : " . round($duree2 * 1000, 2) . " ms\n";

// Sur un volume aussi grand, l'approche par tableau + implode() est
// généralement plus rapide, car PHP évite de recopier une chaîne de plus
// en plus grande à chaque itération.
