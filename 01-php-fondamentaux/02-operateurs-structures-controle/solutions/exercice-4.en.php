<?php

$motDePasse = "secret1234";

$longueurValide = strlen($motDePasse) >= 8;
$contientChiffre = preg_match('/[0-9]/', $motDePasse) === 1;

if ($longueurValide && $contientChiffre) {
    echo "valid";
} else {
    echo "invalid";
}
