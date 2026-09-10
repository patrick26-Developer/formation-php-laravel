<?php

declare(strict_types=1);

function diviserSecurise(float $a, float $b): float {
    if ($b === 0.0) {
        throw new Exception("Division by zero is not allowed.");
    }

    return $a / $b;
}

$paires = [[10, 2], [9, 3], [5, 0]];

foreach ($paires as [$a, $b]) {
    try {
        echo "$a / $b = " . diviserSecurise($a, $b) . "\n";
    } catch (Exception $e) {
        echo "Error for $a / $b: " . $e->getMessage() . "\n";
    }
}
