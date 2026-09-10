<?php

$paragraphe = "PHP is a programming language particularly well suited to web development.";

$mots = explode(" ", $paragraphe);
$nombreMots = count($mots);

$nombreCaracteres = strlen(str_replace(" ", "", $paragraphe));

$motLePlusLong = "";
foreach ($mots as $mot) {
    // Strip any trailing punctuation to compare the word's real length
    $motNettoye = rtrim($mot, ".,!?");
    if (strlen($motNettoye) > strlen($motLePlusLong)) {
        $motLePlusLong = $motNettoye;
    }
}

echo "Number of words: $nombreMots\n";
echo "Number of characters (excluding spaces): $nombreCaracteres\n";
echo "Longest word: $motLePlusLong\n";
