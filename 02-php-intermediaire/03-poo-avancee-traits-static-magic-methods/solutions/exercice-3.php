<?php

declare(strict_types=1);

class Adresse {
    public function __construct(
        private string $rue,
        private string $codePostal,
        private string $ville,
    ) {
    }

    public function __toString(): string {
        return "$this->rue, $this->codePostal $this->ville";
    }
}

$adresse = new Adresse("12 rue des Lilas", "69000", "Lyon");

echo $adresse; // appelle __toString() automatiquement
