<?php

$etudiants = [
    ["nom" => "Alice", "notes" => [15, 12, 18]],
    ["nom" => "Bob", "notes" => [8, 10, 9]],
    ["nom" => "Claire", "notes" => [17, 16, 19]],
    ["nom" => "David", "notes" => [11, 13, 10]],
];

// On calcule la moyenne de chaque étudiant et on l'ajoute à son tableau,
// pour ne pas la recalculer à chaque comparaison dans usort().
foreach ($etudiants as &$etudiant) {
    $etudiant["moyenne"] = array_sum($etudiant["notes"]) / count($etudiant["notes"]);
}
unset($etudiant); // bonne pratique après une boucle foreach par référence (&)

// usort trie EN PLACE le tableau selon la fonction de comparaison fournie.
// La fonction doit retourner un nombre négatif, nul ou positif selon l'ordre voulu.
usort($etudiants, function (array $a, array $b): int {
    return $b["moyenne"] <=> $a["moyenne"]; // ordre décroissant
});

echo "Classement :\n";
foreach ($etudiants as $rang => $etudiant) {
    $position = $rang + 1;
    echo "$position. " . $etudiant["nom"] . " (" . round($etudiant["moyenne"], 2) . ")\n";
}
