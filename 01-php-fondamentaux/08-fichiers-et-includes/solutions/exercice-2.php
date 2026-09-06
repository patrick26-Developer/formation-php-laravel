<?php

$chemin = __DIR__ . "/mots.txt";

$lignes = file($chemin, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$contenu = file_get_contents($chemin);

echo "Nombre de lignes : " . count($lignes) . "\n";
echo "Nombre de caractères (avec retours à la ligne) : " . strlen($contenu) . "\n";
