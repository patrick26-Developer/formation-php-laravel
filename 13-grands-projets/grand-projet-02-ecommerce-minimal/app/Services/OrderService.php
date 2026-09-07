<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Exceptions\PaiementEchoueException;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function __construct(private readonly PaymentGateway $paymentGateway)
    {
    }

    /**
     * Transforme le panier (session) en commande persistée, avec paiement
     * et décrémentation de stock. Tout se déroule dans UNE TRANSACTION
     * (module 04.2) : si le paiement échoue après création de la commande
     * mais avant la décrémentation du stock, TOUT est annulé — jamais de
     * commande "fantôme" ni de stock incohérent.
     *
     * @throws PaiementEchoueException
     */
    public function passerCommande(User $utilisateur, CartService $panier): Order
    {
        if ($panier->contenu() === []) {
            throw new \InvalidArgumentException('Le panier est vide.');
        }

        return DB::transaction(function () use ($utilisateur, $panier) {
            $lignes = $panier->lignesAvecProduits();
            $this->verifierDisponibiliteStock($lignes);

            $total = array_sum(array_map(
                fn ($ligne) => (float) $ligne['produit']->prix * $ligne['quantite'],
                $lignes
            ));

            $commande = Order::create([
                'user_id' => $utilisateur->id,
                'statut' => 'en_attente',
                'total' => $total,
            ]);

            foreach ($lignes as $ligne) {
                $commande->items()->create([
                    'product_id' => $ligne['produit']->id,
                    'nom_produit' => $ligne['produit']->nom,
                    'prix_unitaire' => $ligne['produit']->prix,
                    'quantite' => $ligne['quantite'],
                ]);

                // decrement() génère UPDATE products SET stock = stock - X,
                // une opération atomique côté base de données — évite la
                // "race condition" de lire le stock puis le réécrire
                // séparément (deux requêtes), qui perdrait des décréments
                // sous forte concurrence (rappel du module 04.2).
                $ligne['produit']->decrement('stock', $ligne['quantite']);
            }

            try {
                $this->paymentGateway->payer($total, (string) $commande->id);
            } catch (PaiementEchoueException $e) {
                // Lever l'exception À L'INTÉRIEUR de la transaction la fait
                // automatiquement annuler (rollback) par DB::transaction() :
                // ni la commande, ni le stock décrémenté ne sont conservés.
                throw $e;
            }

            $commande->update(['statut' => 'payee']);
            $panier->vider();

            return $commande->fresh('items');
        });
    }

    /**
     * @param array<int, array{produit: Product, quantite: int}> $lignes
     */
    private function verifierDisponibiliteStock(array $lignes): void
    {
        foreach ($lignes as $ligne) {
            if ($ligne['produit']->stock < $ligne['quantite']) {
                throw new \InvalidArgumentException(
                    "Stock insuffisant pour \"{$ligne['produit']->nom}\" (demandé : {$ligne['quantite']}, disponible : {$ligne['produit']->stock})."
                );
            }
        }
    }
}
