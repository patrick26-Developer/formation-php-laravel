<?php

// Prédictions (à comparer avec l'exécution réelle) :
// "0" == false        -> true  ("0" est une chaîne "falsy", convertie en false)
// "" == null          -> true  (chaîne vide et null sont tous deux "falsy")
// "abc" == 0          -> false (PHP 8+ : une chaîne non numérique n'est plus convertie en 0)
// 1 === 1.0           -> false (int !== float, même si la valeur numérique est égale)
// null == false        -> true  (null est "falsy")

var_dump("0" == false);
var_dump("" == null);
var_dump("abc" == 0);
var_dump(1 === 1.0);
var_dump(null == false);
