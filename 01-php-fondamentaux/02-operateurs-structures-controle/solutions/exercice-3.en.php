<?php

$age = 15;

// match(true) evaluates each branch as a boolean condition
// and returns the first one that's true. More concise than a chain
// of if/elseif, and match always compares in strict mode.
$categorie = match (true) {
    $age < 13 => "Child",
    $age < 18 => "Teenager",
    $age < 65 => "Adult",
    default => "Senior",
};

echo $categorie;

// Comparison: this version avoids repeating "elseif" on every line
// and makes it explicit that we're aiming to get ONE value (assigned
// to $categorie), rather than executing a block of statements.
