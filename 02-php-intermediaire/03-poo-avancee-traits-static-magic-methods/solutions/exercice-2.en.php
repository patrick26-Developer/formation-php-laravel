<?php

declare(strict_types=1);

class Produit {
    private static int $nombreCrees = 0;

    public function __construct(private string $nom) {
        self::$nombreCrees++;
    }

    public static function getNombreCrees(): int {
        return self::$nombreCrees;
    }
}

new Produit("Clavier");
new Produit("Souris");
new Produit("Écran");

echo "Products created: " . Produit::getNombreCrees(); // 3
