<?php

$cheminJournal = __DIR__ . "/journal.txt";
$ligne = "[" . date('Y-m-d H:i:s') . "] Script exécuté\n";

file_put_contents($cheminJournal, $ligne, FILE_APPEND);

echo "Ligne ajoutée au journal.\n";
echo file_get_contents($cheminJournal);
