<?php

declare(strict_types=1);

use App\Contracts\PaymentGateway;
use App\Exceptions\PaiementEchoueException;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('passer commande crée la commande, décrémente le stock, et vide le panier', function () {
    $utilisateur = User::factory()->create();
    $produit = Product::factory()->create(['prix' => 10.00, 'stock' => 5]);

    $panier = new CartService();
    $panier->ajouter($produit, 2);

    $commande = app(OrderService::class)->passerCommande($utilisateur, $panier);

    expect($commande->statut)->toBe('payee')
        ->and($commande->total)->toEqual('20.00')
        ->and($commande->items)->toHaveCount(1)
        ->and($produit->fresh()->stock)->toBe(3)
        ->and($panier->contenu())->toBe([]);
});

test('passer commande échoue si le stock est insuffisant, sans rien persister', function () {
    $utilisateur = User::factory()->create();
    $produit = Product::factory()->create(['stock' => 1]);

    $panier = new CartService();
    $panier->ajouter($produit, 5); // demande plus que le stock disponible

    expect(fn () => app(OrderService::class)->passerCommande($utilisateur, $panier))
        ->toThrow(InvalidArgumentException::class);

    expect($produit->fresh()->stock)->toBe(1) // stock INCHANGÉ
        ->and(\App\Models\Order::count())->toBe(0); // aucune commande créée
});

test('un échec de paiement annule toute la transaction (rollback)', function () {
    // On lie une fausse passerelle qui échoue TOUJOURS, pour ce test précis.
    $this->app->bind(PaymentGateway::class, function () {
        return new class implements PaymentGateway {
            public function payer(float $montant, string $referenceCommande): void
            {
                throw new PaiementEchoueException('Paiement refusé (test).');
            }
        };
    });

    $utilisateur = User::factory()->create();
    $produit = Product::factory()->create(['stock' => 10]);

    $panier = new CartService();
    $panier->ajouter($produit, 3);

    expect(fn () => app(OrderService::class)->passerCommande($utilisateur, $panier))
        ->toThrow(PaiementEchoueException::class);

    // Le rollback de la transaction doit avoir annulé la décrémentation
    // de stock ET la création de la commande, malgré l'ordre des opérations.
    expect($produit->fresh()->stock)->toBe(10)
        ->and(\App\Models\Order::count())->toBe(0);
});
