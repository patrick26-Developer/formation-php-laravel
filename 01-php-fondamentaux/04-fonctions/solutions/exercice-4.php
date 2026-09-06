<?php

declare(strict_types=1);

function diviser(int $a, int $b): float {
    return $a / $b;
}

echo diviser(10, 2) . "\n"; // 5 : fonctionne, deux entiers valides

// diviser("10", 2);
// Avec declare(strict_types=1), cet appel lève :
// TypeError: diviser(): Argument #1 ($a) must be of type int, string given
//
// Sans strict_types (mode par défaut), PHP aurait silencieusement converti
// "10" en entier 10 et l'appel aurait fonctionné. strict_types force à être
// explicite : soit on caste avant l'appel ((int) "10"), soit on assume
// que l'appelant fournit déjà le bon type.
