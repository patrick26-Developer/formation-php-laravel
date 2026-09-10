<?php

declare(strict_types=1);

$n = 100_000;

// Approach 1: direct concatenation
$debut1 = microtime(true);
$resultat1 = '';
for ($i = 0; $i < $n; $i++) {
    $resultat1 .= "line $i\n";
}
$duree1 = microtime(true) - $debut1;

// Approach 2: accumulate into an array, then implode() once
$debut2 = microtime(true);
$lignes = [];
for ($i = 0; $i < $n; $i++) {
    $lignes[] = "line $i";
}
$resultat2 = implode("\n", $lignes);
$duree2 = microtime(true) - $debut2;

echo "Direct concatenation: " . round($duree1 * 1000, 2) . " ms\n";
echo "Array + implode: " . round($duree2 * 1000, 2) . " ms\n";

// On a volume this large, the array + implode() approach is generally
// faster, because PHP avoids recopying an ever-larger string on every
// iteration.
