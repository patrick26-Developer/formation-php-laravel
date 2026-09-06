<?php

declare(strict_types=1);

class Facture
{
    public function __construct(private float $montantHT)
    {
    }

    public function calculerTotal(): float
    {
        return $this->montantHT * 1.2;
    }
}
