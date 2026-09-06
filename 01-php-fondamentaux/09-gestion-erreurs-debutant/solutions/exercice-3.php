<?php

declare(strict_types=1);

function validerAge(int $age): int {
    if ($age < 0 || $age > 150) {
        throw new Exception("Âge invalide : $age");
    }

    return $age;
}

$ages = [25, -5, 200, 40];

foreach ($ages as $age) {
    try {
        $ageValide = validerAge($age);
        echo "Âge valide : $ageValide\n";
    } catch (Exception $e) {
        // Le catch est À L'INTÉRIEUR de la boucle : une exception sur une
        // valeur n'interrompt pas le traitement des valeurs suivantes.
        echo "Ignoré : " . $e->getMessage() . "\n";
    }
}
