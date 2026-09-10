<?php

declare(strict_types=1);

$debut = microtime(true);

$somme = 0;
for ($i = 1; $i <= 5_000_000; $i++) {
    $somme += $i ** 2;
}

$duree = microtime(true) - $debut;

echo "Sum: $somme\n";
echo "Duration: " . round($duree * 1000, 2) . " ms\n";
