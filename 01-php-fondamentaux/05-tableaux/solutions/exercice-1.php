<?php

$courses = ["pain", "beurre", "oeufs", "farine", "sucre"];

$courses[] = "lait";
echo "Nombre d'articles : " . count($courses) . "\n";

var_dump(in_array("lait", $courses)); // true

$premier = array_shift($courses); // retire ET retourne le premier élément
echo "Article retiré : $premier\n";
print_r($courses);
