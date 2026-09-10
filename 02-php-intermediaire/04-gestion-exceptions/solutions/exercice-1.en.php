<?php

declare(strict_types=1);

class AgeInvalideException extends Exception {
}

function validerAge(int $age): int {
    if ($age < 0 || $age > 150) {
        throw new AgeInvalideException("Invalid age: $age. Must be between 0 and 150.");
    }

    return $age;
}

foreach ([25, -5, 200] as $age) {
    try {
        echo "Valid age: " . validerAge($age) . "\n";
    } catch (AgeInvalideException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
