<?php

$cheminJournal = __DIR__ . "/journal.txt";
$ligne = "[" . date('Y-m-d H:i:s') . "] Script executed\n";

file_put_contents($cheminJournal, $ligne, FILE_APPEND);

echo "Line added to the log.\n";
echo file_get_contents($cheminJournal);
