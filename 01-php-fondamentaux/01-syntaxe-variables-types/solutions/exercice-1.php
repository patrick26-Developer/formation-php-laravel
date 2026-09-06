<?php

// Déclaration des variables demandées
$prenom = "Alice";
$age = 28;
$ville = "Lyon";
$estEtudiant = false;

// Interpolation directe dans une chaîne entre guillemets doubles.
// Pour un booléen, on utilise un opérateur ternaire pour l'afficher en "oui"/"non"
// plutôt que 1/0 (comportement par défaut de PHP quand un bool est concaténé).
$estEtudiantTexte = $estEtudiant ? "oui" : "non";

echo "Je m'appelle $prenom, j'ai $age ans, je vis à $ville, et je suis étudiant(e) : $estEtudiantTexte";
