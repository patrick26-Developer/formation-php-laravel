<?php

declare(strict_types=1);

$debut = microtime(true);

$somme = 0;
for ($i = 1; $i <= 5_000_000; $i++) {
    $somme += $i ** 2;
}

$duree = microtime(true) - $debut;

echo "Somme : $somme\n";
echo "Durée : " . round($duree * 1000, 2) . " ms\n";
