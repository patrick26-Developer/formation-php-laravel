<?php

// Declaring the requested variables
$prenom = "Alice";
$age = 28;
$ville = "Lyon";
$estEtudiant = false;

// Direct interpolation inside a double-quoted string.
// For a boolean, we use a ternary operator to display it as "yes"/"no"
// rather than 1/0 (PHP's default behavior when a bool is concatenated).
$estEtudiantTexte = $estEtudiant ? "yes" : "no";

echo "My name is $prenom, I'm $age years old, I live in $ville, and I'm a student: $estEtudiantTexte";
