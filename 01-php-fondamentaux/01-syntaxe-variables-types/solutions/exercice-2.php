<?php

$unEntier = 42;
$unFlottant = 3.14;
$uneChaine = "Bonjour";
$unBooleen = true;
$unTableau = ["a", "b", "c"];

$variables = [
    'unEntier' => $unEntier,
    'unFlottant' => $unFlottant,
    'uneChaine' => $uneChaine,
    'unBooleen' => $unBooleen,
    'unTableau' => $unTableau,
];

// On boucle sur toutes les variables pour éviter de répéter 5 fois le même bloc.
// (La boucle foreach est vue en détail au module 01.3, mais elle est assez
// intuitive pour être lisible dès maintenant : "pour chaque paire clé => valeur")
foreach ($variables as $nom => $valeur) {
    echo "--- $nom ---\n";
    echo "Type : " . gettype($valeur) . "\n";
    var_dump($valeur);
    echo "\n";
}
