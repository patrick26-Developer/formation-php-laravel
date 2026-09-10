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

echo "Latitude: {$position->latitude}\n";
echo "Longitude: {$position->longitude}\n";

// $position->latitude = 0.0;
// Error obtained:
// "Error: Cannot modify readonly property Coordonnees::$latitude"
// readonly guarantees that once the object is constructed, these values can
// never change again — useful for representing immutable data
// (a fixed geographic position, an identifier, a creation date...).
