<?php

declare(strict_types=1);

namespace App;

class Calculatrice {
    public function additionner(int $a, int $b): int {
        return $a + $b;
    }

    public function diviser(float $a, float $b): float {
        if ($b === 0.0) {
            throw new \InvalidArgumentException("Cannot divide by zero.");
        }

        return $a / $b;
    }
}
