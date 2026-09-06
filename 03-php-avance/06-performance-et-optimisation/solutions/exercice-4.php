<?php

declare(strict_types=1);

$tableau = range(1, 10000);

$debut1 = microtime(true);
$derniers1 = array_slice($tableau, 9990, 10);
$duree1 = microtime(true) - $debut1;

$debut2 = microtime(true);
$derniers2 = [];
foreach ($tableau as $valeur) {
    $derniers2[] = $valeur;
    if (count($derniers2) > 10) {
        array_shift($derniers2); // garde seulement les 10 derniers vus
    }
}
$duree2 = microtime(true) - $debut2;

echo "array_slice : " . round($duree1 * 1000, 4) . " ms\n";
echo "Boucle complète : " . round($duree2 * 1000, 4) . " ms\n";

/*
 * Conclusion : array_slice() est très largement plus rapide, car il connaît
 * directement les index à extraire sans parcourir tout le tableau. La version
 * en boucle doit visiter les 10 000 éléments un par un, même si on ne garde
 * que les 10 derniers. Dès qu'on sait QUELS éléments on veut, une fonction
 * native dédiée (ou, pour une vraie base de données, une clause LIMIT/OFFSET
 * du module 02.9) est presque toujours préférable à un parcours manuel complet.
 */
