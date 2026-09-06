<?php

$notes = [12, 15, 8, 17, 10];

$somme = 0;
foreach ($notes as $note) {
    $somme += $note;
}

$moyenne = $somme / count($notes);

echo "Somme : $somme\n";
echo "Moyenne : $moyenne\n";
