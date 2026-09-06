<?php

// --- Code original (fautif), pour référence ---
// $Prix = 15.50
// $quantite = "3"
//
// $total = $prix * $quantite
// echo 'Le total est : $total euros'

// --- Version corrigée ---

// Bug 1 : point-virgule manquant à la fin de chaque instruction.
$prix = 15.50; // Bug 2 : "$Prix" (majuscule) puis "$prix" (minuscule) utilisés
               // comme si c'était la même variable — PHP est sensible à la casse,
               // ce sont deux variables différentes. On uniformise en "$prix".
$quantite = 3;  // Bug 3 : la quantité était une chaîne "3" plutôt qu'un entier 3.
                // Ça n'aurait pas provoqué d'erreur ici (PHP aurait converti
                // automatiquement pour la multiplication), mais ce n'est pas
                // le bon type sémantique pour une quantité.

$total = $prix * $quantite;

// Bug 4 : guillemets simples ('...') n'interpolent pas les variables.
// Le texte affiché aurait été littéralement "Le total est : $total euros".
// Il faut soit des guillemets doubles, soit une concaténation avec le point.
echo "Le total est : $total euros";
