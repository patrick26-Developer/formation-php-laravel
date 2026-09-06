<?php

declare(strict_types=1);

class Livre {
    public function __construct(
        private string $titre,
        private string $auteur,
        private int $annee,
    ) {
    }

    public function presenter(): string {
        return "$this->titre ($this->auteur, $this->annee)";
    }
}

$livre1 = new Livre("1984", "George Orwell", 1949);
$livre2 = new Livre("Le Petit Prince", "Antoine de Saint-Exupéry", 1943);

echo $livre1->presenter() . "\n";
echo $livre2->presenter() . "\n";
