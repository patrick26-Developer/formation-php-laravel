<?php

declare(strict_types=1);

require_once __DIR__ . "/helpers.php";

function listerTaches(array $taches): array {
    // array_values() : une liste vide est un résultat VALIDE, on répond
    // toujours 200, jamais une erreur, même quand $taches est vide.
    return array_values($taches);
}

$tachesVides = [];
repondreJson(listerTaches($tachesVides), 200); // {"..."} -> [] avec code 200

// (Pour tester avec des données : remplissez $tachesVides avant l'appel.)
