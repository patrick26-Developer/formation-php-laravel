<?php

// --- Code original ---
// $compteur = 0;
//
// function incrementer() {
//     $compteur = $compteur + 1;
//     return $compteur;
// }
//
// echo incrementer(); // affiche 1
// echo incrementer(); // affiche 1 (pas 2 !)
// echo $compteur;     // affiche 0
//
// Explication : la variable $compteur DANS la fonction est une variable locale
// totalement différente de la variable $compteur déclarée à l'extérieur.
// À chaque appel, PHP part de "$compteur n'existe pas dans cette fonction",
// donc $compteur + 1 vaut null + 1 = 1 (avec un warning "variable indéfinie").
// La variable globale $compteur, elle, n'est jamais modifiée : elle reste à 0.

// --- Version corrigée : on passe et on retourne explicitement la valeur ---
declare(strict_types=1);

function incrementer(int $valeurActuelle): int {
    return $valeurActuelle + 1;
}

$compteur = 0;
$compteur = incrementer($compteur); // 1
$compteur = incrementer($compteur); // 2

echo $compteur; // 2
