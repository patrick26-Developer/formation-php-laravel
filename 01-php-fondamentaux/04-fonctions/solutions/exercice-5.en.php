<?php

$estMajeur = fn(int $age): bool => $age >= 18;
$carre = fn(int $n): int => $n * $n;
$concatener = fn(string $a, string $b): string => $a . $b;

var_dump($estMajeur(20));
var_dump($carre(5));
var_dump($concatener("Hello, ", "World"));

/*
 * An arrow function isn't suitable as soon as you need:
 * - several statements (an arrow function contains only ONE expression,
 *   implicitly returned);
 * - a loop, a switch, or any multi-line control structure;
 * - named intermediate variables for readability.
 * In these cases, a classic function (function ... { ... }) remains the
 * right solution.
 */
