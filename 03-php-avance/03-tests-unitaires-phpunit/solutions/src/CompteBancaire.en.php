<?php

declare(strict_types=1);

namespace App;

class CompteBancaire {
    public function __construct(private float $solde = 0.0) {}

    public function deposer(float $montant): void {
        $this->solde += $montant;
    }

    public function retirer(float $montant): void {
        if ($montant > $this->solde) {
            throw new \Exception("Insufficient balance.");
        }

        $this->solde -= $montant;
    }

    public function getSolde(): float {
        return $this->solde;
    }
}
