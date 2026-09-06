<?php

declare(strict_types=1);

class Coordonnees {
    public function __construct(
        public readonly float $latitude,
        public readonly float $longitude,
    ) {
    }
}

$position = new Coordonnees(45.75, 4.85);

echo "Latitude : {$position->latitude}\n";
echo "Longitude : {$position->longitude}\n";

// $position->latitude = 0.0;
// Erreur obtenue :
// "Error: Cannot modify readonly property Coordonnees::$latitude"
// readonly garantit qu'une fois l'objet construit, ces valeurs ne peuvent
// plus jamais changer — utile pour représenter des données immuables
// (une position géographique fixe, un identifiant, une date de création...).
