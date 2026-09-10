<?php

for ($nombre = 2; $nombre <= 50; $nombre++) {
    $estPremier = true;

    for ($diviseur = 2; $diviseur < $nombre; $diviseur++) {
        if ($nombre % $diviseur === 0) {
            $estPremier = false;
            break; // no need to keep looking for other divisors
        }
    }

    if ($estPremier) {
        echo "$nombre ";
    }
}
