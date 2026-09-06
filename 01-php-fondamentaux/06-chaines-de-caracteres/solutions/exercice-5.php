<?php

$paragraphe = "PHP est un langage de programmation particulièrement adapté au développement web.";

$mots = explode(" ", $paragraphe);
$nombreMots = count($mots);

$nombreCaracteres = strlen(str_replace(" ", "", $paragraphe));

$motLePlusLong = "";
foreach ($mots as $mot) {
    // On retire une éventuelle ponctuation finale pour comparer la vraie longueur du mot
    $motNettoye = rtrim($mot, ".,!?");
    if (strlen($motNettoye) > strlen($motLePlusLong)) {
        $motLePlusLong = $motNettoye;
    }
}

echo "Nombre de mots : $nombreMots\n";
echo "Nombre de caractères (sans espaces) : $nombreCaracteres\n";
echo "Mot le plus long : $motLePlusLong\n";
