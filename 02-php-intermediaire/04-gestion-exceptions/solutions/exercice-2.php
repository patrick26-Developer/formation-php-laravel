<?php

declare(strict_types=1);

class StockInsuffisantException extends Exception {
    public function __construct(
        private int $stockDisponible,
        private int $quantiteDemandee,
    ) {
        parent::__construct("Stock insuffisant : $stockDisponible disponible(s), $quantiteDemandee demandé(s).");
    }

    public function getStockDisponible(): int {
        return $this->stockDisponible;
    }

    public function getQuantiteDemandee(): int {
        return $this->quantiteDemandee;
    }
}

class Stock {
    public function __construct(private int $quantite) {}

    public function retirer(int $quantite): void {
        if ($quantite > $this->quantite) {
            throw new StockInsuffisantException($this->quantite, $quantite);
        }

        $this->quantite -= $quantite;
    }
}

$stock = new Stock(5);

try {
    $stock->retirer(10);
} catch (StockInsuffisantException $e) {
    $manquant = $e->getQuantiteDemandee() - $e->getStockDisponible();
    echo "Impossible de traiter la commande : il manque $manquant unité(s).\n";
}
