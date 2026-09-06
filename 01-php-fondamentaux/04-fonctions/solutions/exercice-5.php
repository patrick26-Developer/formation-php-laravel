<?php

$estMajeur = fn(int $age): bool => $age >= 18;
$carre = fn(int $n): int => $n * $n;
$concatener = fn(string $a, string $b): string => $a . $b;

var_dump($estMajeur(20));
var_dump($carre(5));
var_dump($concatener("Hello, ", "World"));

/*
 * Une fonction fléchée n'est pas adaptée dès qu'on a besoin de :
 * - plusieurs instructions (une fonction fléchée ne contient qu'UNE seule
 *   expression, implicitement retournée) ;
 * - une boucle, un switch, ou toute structure de contrôle sur plusieurs lignes ;
 * - des variables intermédiaires nommées pour la lisibilité.
 * Dans ces cas, une fonction classique (function ... { ... }) reste la bonne solution.
 */
