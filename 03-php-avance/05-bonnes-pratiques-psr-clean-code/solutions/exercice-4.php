<?php

declare(strict_types=1);

// --- Original ---
// function peutPublier(int $role): bool {
//     return $role === 1 || $role === 2;
// }
// Que représentent 1 et 2 ? Impossible à deviner sans chercher ailleurs.

enum Role: int
{
    case Lecteur = 0;
    case Editeur = 1;
    case Admin = 2;
}

function peutPublier(Role $role): bool
{
    return $role === Role::Editeur || $role === Role::Admin;
}

var_dump(peutPublier(Role::Editeur)); // true
var_dump(peutPublier(Role::Lecteur)); // false

// Le code se lit maintenant sans avoir besoin de documentation externe
// pour savoir ce que représentent les valeurs 1 et 2.
