<?php

declare(strict_types=1);

class AgeInvalideException extends Exception {
}

function validerAge(int $age): int {
    if ($age < 0 || $age > 150) {
        throw new AgeInvalideException("Âge invalide : $age. Doit être entre 0 et 150.");
    }

    return $age;
}

foreach ([25, -5, 200] as $age) {
    try {
        echo "Âge valide : " . validerAge($age) . "\n";
    } catch (AgeInvalideException $e) {
        echo "Erreur : " . $e->getMessage() . "\n";
    }
}
