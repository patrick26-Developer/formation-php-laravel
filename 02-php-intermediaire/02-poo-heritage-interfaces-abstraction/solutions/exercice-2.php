<?php

declare(strict_types=1);

class Vehicule {
    public function __construct(protected string $marque) {}

    public function demarrer(): string {
        return "$this->marque démarre.";
    }
}

class Voiture extends Vehicule {
    public function demarrer(): string {
        return parent::demarrer() . " Vérification de la ceinture.";
    }
}

$voiture = new Voiture("Renault");
echo $voiture->demarrer(); // Renault démarre. Vérification de la ceinture.
