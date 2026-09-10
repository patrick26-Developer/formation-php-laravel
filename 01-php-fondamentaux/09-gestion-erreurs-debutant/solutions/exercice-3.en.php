<?php

declare(strict_types=1);

function validerAge(int $age): int {
    if ($age < 0 || $age > 150) {
        throw new Exception("Invalid age: $age");
    }

    return $age;
}

$ages = [25, -5, 200, 40];

foreach ($ages as $age) {
    try {
        $ageValide = validerAge($age);
        echo "Valid age: $ageValide\n";
    } catch (Exception $e) {
        // The catch is INSIDE the loop: an exception on one value doesn't
        // stop the following values from being processed.
        echo "Skipped: " . $e->getMessage() . "\n";
    }
}
