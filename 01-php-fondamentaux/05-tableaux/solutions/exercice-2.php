<?php

$personne = [
    "nom" => "Dupont",
    "email" => "dupont@example.com",
    "telephone" => "06 12 34 56 78",
];

foreach ($personne as $cle => $valeur) {
    echo ucfirst($cle) . " : $valeur\n";
}
