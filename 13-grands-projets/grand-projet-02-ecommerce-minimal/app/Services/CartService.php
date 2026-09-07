<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

/**
 * Le panier vit en SESSION, pas en base de données : un visiteur non
 * connecté doit pouvoir ajouter des produits avant de se créer un compte
 * (rappel du module 02.5 sur les sessions). Seule la COMMANDE finale,
 * une fois validée, est persistée en base (module OrderService).
 */
class CartService
{
    private const CLE_SESSION = 'panier';

    /**
     * @return array<int, array{product_id: int, quantite: int}>
     */
    public function contenu(): array
    {
        return Session::get(self::CLE_SESSION, []);
    }

    public function ajouter(Product $product, int $quantite = 1): void
    {
        $panier = $this->contenu();

        $panier[$product->id] = [
            'product_id' => $product->id,
            'quantite' => ($panier[$product->id]['quantite'] ?? 0) + $quantite,
        ];

        Session::put(self::CLE_SESSION, $panier);
    }

    public function retirer(int $productId): void
    {
        $panier = $this->contenu();
        unset($panier[$productId]);
        Session::put(self::CLE_SESSION, $panier);
    }

    public function vider(): void
    {
        Session::forget(self::CLE_SESSION);
    }

    /**
     * Recalcule le total à partir des prix ACTUELS en base — jamais
     * depuis une valeur mise en cache dans la session, qui pourrait être
     * manipulée côté client ou simplement devenue obsolète.
     */
    public function total(): float
    {
        $total = 0.0;

        foreach ($this->lignesAvecProduits() as $ligne) {
            $total += (float) $ligne['produit']->prix * $ligne['quantite'];
        }

        return $total;
    }

    /**
     * @return array<int, array{produit: Product, quantite: int}>
     */
    public function lignesAvecProduits(): array
    {
        $lignes = [];

        foreach ($this->contenu() as $productId => $item) {
            $produit = Product::find($productId);

            if ($produit !== null) {
                $lignes[] = ['produit' => $produit, 'quantite' => $item['quantite']];
            }
        }

        return $lignes;
    }
}
