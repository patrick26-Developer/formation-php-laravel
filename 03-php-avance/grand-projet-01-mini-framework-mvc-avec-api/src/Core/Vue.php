<?php

declare(strict_types=1);

namespace App\Core;

class Vue
{
    public static function afficher(string $nomVue, array $donnees = []): void
    {
        extract($donnees);
        require __DIR__ . "/../../vues/$nomVue.php";
    }
}
