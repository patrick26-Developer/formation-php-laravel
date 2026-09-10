<?php

$etudiants = [
    ["nom" => "Alice", "notes" => [15, 12, 18]],
    ["nom" => "Bob", "notes" => [8, 10, 9]],
    ["nom" => "Claire", "notes" => [17, 16, 19]],
    ["nom" => "David", "notes" => [11, 13, 10]],
];

// We compute each student's average and add it to their array, so it
// doesn't get recalculated on every comparison inside usort().
foreach ($etudiants as &$etudiant) {
    $etudiant["moyenne"] = array_sum($etudiant["notes"]) / count($etudiant["notes"]);
}
unset($etudiant); // good practice after a foreach loop by reference (&)

// usort sorts the array IN PLACE according to the given comparison function.
// The function must return a negative, zero, or positive number based on the desired order.
usort($etudiants, function (array $a, array $b): int {
    return $b["moyenne"] <=> $a["moyenne"]; // descending order
});

echo "Ranking:\n";
foreach ($etudiants as $rang => $etudiant) {
    $position = $rang + 1;
    echo "$position. " . $etudiant["nom"] . " (" . round($etudiant["moyenne"], 2) . ")\n";
}
