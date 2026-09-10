<?php

declare(strict_types=1);

require_once __DIR__ . "/Vue.en.php";

class ProduitController {
    public function liste(): void {
        $produits = [
            ['nom' => 'Mechanical keyboard', 'prix' => 49.99],
            ['nom' => 'Wireless mouse', 'prix' => 19.99],
            ['nom' => '27-inch monitor', 'prix' => 199.00],
        ];

        Vue::afficher('produits/liste.en', ['produits' => $produits]);
    }
}
