<?php

declare(strict_types=1);

class Vehicule {
    public function __construct(protected string $marque) {}

    public function demarrer(): string {
        return "$this->marque starts.";
    }
}

class Voiture extends Vehicule {
    public function ouvrirCoffre(): string {
        return "The $this->marque's trunk opens.";
    }
}

class Moto extends Vehicule {
    public function fairePetPet(): string {
        return "The $this->marque goes vroom-vroom!";
    }
}

$voiture = new Voiture("Peugeot");
echo $voiture->demarrer() . "\n";
echo $voiture->ouvrirCoffre() . "\n";

$moto = new Moto("Yamaha");
echo $moto->demarrer() . "\n";
echo $moto->fairePetPet() . "\n";
