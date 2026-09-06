<?php

declare(strict_types=1);

// --- Original ---
// function calc($a, $b, $t) {
//     if ($t === 1) {
//         return $a + $b;
//     }
//     return $a - $b;
// }

// --- Renommé pour exprimer l'intention réelle ---
function calculerMontant(float $premierMontant, float $secondMontant, int $typeOperation): float
{
    if ($typeOperation === 1) {
        return $premierMontant + $secondMontant;
    }

    return $premierMontant - $secondMontant;
}

// Remarque : $typeOperation reste peu clair (que signifie "1" ?).
// Un enum (module 02.3) irait encore plus loin :
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
