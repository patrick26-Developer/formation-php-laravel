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
        array_shift($derniers2); // keeps only the last 10 seen
    }
}
$duree2 = microtime(true) - $debut2;

echo "array_slice: " . round($duree1 * 1000, 4) . " ms\n";
echo "Full loop: " . round($duree2 * 1000, 4) . " ms\n";

/*
 * Conclusion: array_slice() is vastly faster, because it knows directly
 * which indexes to extract without walking the whole array. The loop
 * version has to visit all 10,000 elements one by one, even though it
 * only keeps the last 10. As soon as you know WHICH elements you want,
 * a dedicated native function (or, for a real database, a LIMIT/OFFSET
 * clause from module 02.9) is almost always preferable to a full manual
 * traversal.
 */
