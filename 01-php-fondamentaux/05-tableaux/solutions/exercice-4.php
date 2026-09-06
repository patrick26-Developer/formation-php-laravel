<?php

$etudiants = [
    ["nom" => "Alice", "notes" => [15, 12, 18]],
    ["nom" => "Bob", "notes" => [8, 10, 9]],
    ["nom" => "Claire", "notes" => [17, 16, 19]],
    ["nom" => "David", "notes" => [11, 13, 10]],
];

$meilleureMoyenne = 0;
$meilleurEtudiant = "";

foreach ($etudiants as $etudiant) {
    $moyenne = array_sum($etudiant["notes"]) / count($etudiant["notes"]);
    echo $etudiant["nom"] . " : " . round($moyenne, 2) . "\n";

    if ($moyenne > $meilleureMoyenne) {
        $meilleureMoyenne = $moyenne;
        $meilleurEtudiant = $etudiant["nom"];
    }
}

echo "\nMeilleure moyenne : $meilleurEtudiant avec " . round($meilleureMoyenne, 2) . "\n";
