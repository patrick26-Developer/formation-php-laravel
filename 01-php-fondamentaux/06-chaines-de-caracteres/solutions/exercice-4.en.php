<?php

declare(strict_types=1);

function estTelephoneValide(string $numero): bool {
    // First strip spaces to simplify the regex
    $numeroNettoye = str_replace(' ', '', $numero);

    // ^0        : starts with 0
    // [1-9]     : followed by a digit from 1 to 9 (second digit)
    // [0-9]{8}$ : then exactly 8 digits until the end (total: 10 digits)
    return preg_match('/^0[1-9][0-9]{8}$/', $numeroNettoye) === 1;
}

var_dump(estTelephoneValide("06 12 34 56 78")); // true
var_dump(estTelephoneValide("0612345678"));      // true
var_dump(estTelephoneValide("06123456"));         // false (too short)
var_dump(estTelephoneValide("00 12 34 56 78"));   // false (invalid second digit)
