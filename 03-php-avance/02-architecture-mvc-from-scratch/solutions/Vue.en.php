<?php

declare(strict_types=1);

class Vue {
    public static function afficher(string $nomVue, array $donnees = []): void {
        extract($donnees);
        require __DIR__ . "/vues/$nomVue.php";
    }
}
