<?php

declare(strict_types=1);

require_once __DIR__ . "/Vue.php";

class ProduitController {
    public function liste(): void {
        $produits = [
            ['nom' => 'Clavier mécanique', 'prix' => 49.99],
            ['nom' => 'Souris sans fil', 'prix' => 19.99],
            ['nom' => 'Écran 27 pouces', 'prix' => 199.00],
        ];

        Vue::afficher('produits/liste', ['produits' => $produits]);
    }
}
