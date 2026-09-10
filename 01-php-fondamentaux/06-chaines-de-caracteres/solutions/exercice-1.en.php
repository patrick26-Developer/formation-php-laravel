<?php

$saisie = "   Alice DUPONT  ";

$nettoye = trim($saisie); // "Alice DUPONT"
[$prenom, $nom] = explode(" ", $nettoye);

$resultat = ucfirst(strtolower($prenom)) . " " . ucfirst(strtolower($nom));

echo $resultat; // Alice Dupont
