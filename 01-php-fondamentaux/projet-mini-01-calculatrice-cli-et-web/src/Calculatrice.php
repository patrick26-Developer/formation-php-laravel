<?php

declare(strict_types=1);

/**
 * Logique de calcul partagée entre l'interface CLI et l'interface Web.
 * Isoler cette logique dans un fichier dédié évite de la dupliquer :
 * les deux points d'entrée (cli.php et web/index.php) l'incluent et
 * l'utilisent de la même façon.
 */

function calculer(float $a, string $operation, float $b): float {
    return match ($operation) {
        '+' => $a + $b,
        '-' => $a - $b,
        '*' => $a * $b,
        '/' => diviser($a, $b),
        default => throw new InvalidArgumentException("Opération inconnue : $operation"),
    };
}

function diviser(float $a, float $b): float {
    if ($b === 0.0) {
        throw new InvalidArgumentException("Division par zéro impossible.");
    }

    return $a / $b;
}

function operationsDisponibles(): array {
    return ['+', '-', '*', '/'];
}
