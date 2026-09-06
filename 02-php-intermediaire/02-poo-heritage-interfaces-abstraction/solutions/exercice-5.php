<?php

declare(strict_types=1);

abstract class FormeGeometrique {
    abstract public function calculerAire(): float;
}

class Rectangle extends FormeGeometrique {
    public function __construct(private float $largeur, private float $hauteur) {}

    public function calculerAire(): float {
        return $this->largeur * $this->hauteur;
    }
}

class Cercle extends FormeGeometrique {
    public function __construct(private float $rayon) {}

    public function calculerAire(): float {
        return M_PI * $this->rayon ** 2;
    }
}

class Triangle extends FormeGeometrique {
    public function __construct(private float $base, private float $hauteur) {}

    public function calculerAire(): float {
        return ($this->base * $this->hauteur) / 2;
    }
}

/**
 * @param FormeGeometrique[] $formes
 */
function calculerAireTotale(array $formes): float {
    // On ne teste jamais "if ($forme instanceof Rectangle)" : le polymorphisme
    // garantit que TOUTES les formes savent répondre à calculerAire().
    return array_reduce(
        $formes,
        fn(float $total, FormeGeometrique $forme): float => $total + $forme->calculerAire(),
        0.0
    );
}

$formes = [
    new Rectangle(4, 5),
    new Cercle(3),
    new Triangle(6, 4),
];

echo "Aire totale : " . round(calculerAireTotale($formes), 2) . " m²";
