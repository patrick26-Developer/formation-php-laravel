<?php

$unEntier = 42;
$unFlottant = 3.14;
$uneChaine = "Hello";
$unBooleen = true;
$unTableau = ["a", "b", "c"];

$variables = [
    'unEntier' => $unEntier,
    'unFlottant' => $unFlottant,
    'uneChaine' => $uneChaine,
    'unBooleen' => $unBooleen,
    'unTableau' => $unTableau,
];

// We loop over every variable to avoid repeating the same block 5 times.
// (The foreach loop is covered in detail in module 01.3, but it's intuitive
// enough to read right now: "for each key => value pair")
foreach ($variables as $nom => $valeur) {
    echo "--- $nom ---\n";
    echo "Type: " . gettype($valeur) . "\n";
    var_dump($valeur);
    echo "\n";
}
