<?php

declare(strict_types=1);

abstract class Employe {
    public function __construct(protected string $nom) {}

    abstract public function calculerSalaire(): float;

    public function presenter(): string {
        return "$this->nom: " . round($this->calculerSalaire(), 2) . " €";
    }
}

class EmployeFixe extends Employe {
    public function __construct(string $nom, private float $salaireMensuel) {
        parent::__construct($nom);
    }

    public function calculerSalaire(): float {
        return $this->salaireMensuel;
    }
}

class EmployeCommission extends Employe {
    public function __construct(
        string $nom,
        private float $salaireBase,
        private float $tauxCommission,
        private float $montantVentes,
    ) {
        parent::__construct($nom);
    }

    public function calculerSalaire(): float {
        return $this->salaireBase + ($this->montantVentes * $this->tauxCommission);
    }
}

$employes = [
    new EmployeFixe("Alice", 2500),
    new EmployeCommission("Bob", 1500, 0.05, 10000),
];

foreach ($employes as $employe) {
    echo $employe->presenter() . "\n";
}
