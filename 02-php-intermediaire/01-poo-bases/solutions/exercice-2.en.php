<?php

declare(strict_types=1);

class Thermometre {
    public function __construct(
        private float $temperature,
    ) {
    }

    public function getTemperature(): float {
        return $this->temperature;
    }

    public function augmenter(float $degres): void {
        $this->temperature += $degres;
    }
}

$thermometre = new Thermometre(20.0);
echo $thermometre->getTemperature() . "\n"; // 20

$thermometre->augmenter(5.5);
echo $thermometre->getTemperature() . "\n"; // 25.5

// $thermometre->temperature; // Error: private property, not accessible from outside
