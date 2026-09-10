<?php

declare(strict_types=1);

class Vehicule {
    public function __construct(protected string $marque) {}

    public function demarrer(): string {
        return "$this->marque starts.";
    }
}

class Voiture extends Vehicule {
    public function demarrer(): string {
        return parent::demarrer() . " Checking the seatbelt.";
    }
}

$voiture = new Voiture("Renault");
echo $voiture->demarrer(); // Renault starts. Checking the seatbelt.
