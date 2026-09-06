<?php

declare(strict_types=1);

class CompteBancaire {
    public function __construct(
        private float $solde = 0.0,
    ) {
    }

    public function deposer(float $montant): void {
        $this->solde += $montant;
    }

    public function retirer(float $montant): void {
        if ($montant > $this->solde) {
            throw new Exception("Solde insuffisant : solde actuel {$this->solde}€, retrait demandé {$montant}€.");
        }

        $this->solde -= $montant;
    }

    public function getSolde(): float {
        return $this->solde;
    }
}

$compte = new CompteBancaire(100);

$compte->retirer(30);
echo "Solde après retrait valide : " . $compte->getSolde() . "\n"; // 70

try {
    $compte->retirer(1000);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
}
