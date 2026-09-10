<?php

// --- Original code ---
// $compteur = 0;
//
// function incrementer() {
//     $compteur = $compteur + 1;
//     return $compteur;
// }
//
// echo incrementer(); // prints 1
// echo incrementer(); // prints 1 (not 2!)
// echo $compteur;     // prints 0
//
// Explanation: the $compteur variable INSIDE the function is a local
// variable totally different from the $compteur variable declared outside.
// On every call, PHP starts from "$compteur doesn't exist in this function",
// so $compteur + 1 equals null + 1 = 1 (with an "undefined variable" warning).
// The global $compteur variable itself is never modified: it stays at 0.

// --- Corrected version: explicitly pass and return the value ---
declare(strict_types=1);

function incrementer(int $valeurActuelle): int {
    return $valeurActuelle + 1;
}

$compteur = 0;
$compteur = incrementer($compteur); // 1
$compteur = incrementer($compteur); // 2

echo $compteur; // 2
