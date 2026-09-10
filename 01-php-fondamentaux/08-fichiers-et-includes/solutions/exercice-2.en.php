<?php

$chemin = __DIR__ . "/mots.en.txt";

$lignes = file($chemin, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$contenu = file_get_contents($chemin);

echo "Number of lines: " . count($lignes) . "\n";
echo "Number of characters (including line breaks): " . strlen($contenu) . "\n";
