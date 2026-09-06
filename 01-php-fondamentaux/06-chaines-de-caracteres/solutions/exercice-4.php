<?php

declare(strict_types=1);

function estTelephoneValide(string $numero): bool {
    // On retire d'abord les espaces pour simplifier la regex
    $numeroNettoye = str_replace(' ', '', $numero);

    // ^0        : commence par 0
    // [1-9]     : suivi d'un chiffre de 1 à 9 (deuxième chiffre)
    // [0-9]{8}$ : puis exactement 8 chiffres jusqu'à la fin (total : 10 chiffres)
    return preg_match('/^0[1-9][0-9]{8}$/', $numeroNettoye) === 1;
}

var_dump(estTelephoneValide("06 12 34 56 78")); // true
var_dump(estTelephoneValide("0612345678"));      // true
var_dump(estTelephoneValide("06123456"));         // false (trop court)
var_dump(estTelephoneValide("00 12 34 56 78"));   // false (deuxième chiffre invalide)
