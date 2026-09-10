<?php

declare(strict_types=1);

abstract class FormeGeometrique {
    abstract public function calculerAire(): float;
}

class Rectangle extends FormeGeometrique {
    public function __construct(private float $largeur, private float $hauteur) {}
    public function calculerAire(): float { return $this->largeur * $this->hauteur; }
}

class Cercle extends FormeGeometrique {
    public function __construct(private float $rayon) {}
    public function calculerAire(): float { return M_PI * $this->rayon ** 2; }
}

class Triangle extends FormeGeometrique {
    public function __construct(private float $base, private float $hauteur) {}
    public function calculerAire(): float { return ($this->base * $this->hauteur) / 2; }
}

class FormeFactory {
    public static function creer(string $type, array $parametres): FormeGeometrique {
        return match ($type) {
            'rectangle' => new Rectangle($parametres['largeur'], $parametres['hauteur']),
            'cercle' => new Cercle($parametres['rayon']),
            'triangle' => new Triangle($parametres['base'], $parametres['hauteur']),
            default => throw new InvalidArgumentException("Unknown shape type: $type"),
        };
    }
}

$rectangle = FormeFactory::creer('rectangle', ['largeur' => 4, 'hauteur' => 5]);
$cercle = FormeFactory::creer('cercle', ['rayon' => 3]);

echo "Rectangle area: " . $rectangle->calculerAire() . "\n";
echo "Circle area: " . round($cercle->calculerAire(), 2) . "\n";
