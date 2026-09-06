<?php

declare(strict_types=1);

class Produit
{
    public function __construct(
        private string $nom,
    ) {
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}
