<?php

declare(strict_types=1);

class Vehicule {
    public function __construct(protected string $marque) {}

    public function demarrer(): string {
        return "$this->marque démarre.";
    }
}

class Voiture extends Vehicule {
    public function ouvrirCoffre(): string {
        return "Le coffre de la $this->marque s'ouvre.";
    }
}

class Moto extends Vehicule {
    public function fairePetPet(): string {
        return "La $this->marque fait pet-pet !";
    }
}

$voiture = new Voiture("Peugeot");
echo $voiture->demarrer() . "\n";
echo $voiture->ouvrirCoffre() . "\n";

$moto = new Moto("Yamaha");
echo $moto->demarrer() . "\n";
echo $moto->fairePetPet() . "\n";
