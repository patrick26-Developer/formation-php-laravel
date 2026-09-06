<?php

$age = 15;

// match(true) évalue chaque branche comme une condition booléenne
// et retourne la première qui vaut true. Plus concis qu'une chaîne
// de if/elseif, et match compare toujours en mode strict.
$categorie = match (true) {
    $age < 13 => "Enfant",
    $age < 18 => "Adolescent",
    $age < 65 => "Adulte",
    default => "Senior",
};

echo $categorie;

// Comparaison : cette version évite de répéter "elseif" à chaque ligne
// et rend explicite qu'on cherche à obtenir UNE valeur (affectée à $categorie),
// plutôt qu'à exécuter un bloc d'instructions.
