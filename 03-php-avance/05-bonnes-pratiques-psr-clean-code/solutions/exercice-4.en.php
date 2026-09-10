<?php

declare(strict_types=1);

// --- Original ---
// function peutPublier(int $role): bool {
//     return $role === 1 || $role === 2;
// }
// What do 1 and 2 represent? Impossible to guess without looking elsewhere.

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

// The code can now be read without needing external documentation
// to know what the values 1 and 2 represent.
