<?php

declare(strict_types=1);

// --- Original ---
// function calc($a, $b, $t) {
//     if ($t === 1) {
//         return $a + $b;
//     }
//     return $a - $b;
// }

// --- Renamed to express the actual intent ---
function calculerMontant(float $premierMontant, float $secondMontant, int $typeOperation): float
{
    if ($typeOperation === 1) {
        return $premierMontant + $secondMontant;
    }

    return $premierMontant - $secondMontant;
}

// Note: $typeOperation is still unclear (what does "1" mean?).
// An enum (module 02.3) would go even further:
enum TypeOperation
{
    case Addition;
    case Soustraction;
}

function calculerMontantAvecEnum(float $a, float $b, TypeOperation $type): float
{
    return match ($type) {
        TypeOperation::Addition => $a + $b,
        TypeOperation::Soustraction => $a - $b,
    };
}
