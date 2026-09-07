<?php

declare(strict_types=1);

use App\Contracts\PaymentGateway;
use App\Exceptions\PaiementEchoueException;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Services\BillingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('facturer un abonnement émet une facture payée en cas de succès', function () {
    $plan = Plan::create(['nom' => 'Pro', 'prix_mensuel' => 29.00, 'limite_projets' => 20]);
    $tenant = Tenant::create(['nom' => 'Acme']);
    $abonnement = Subscription::create([
        'tenant_id' => $tenant->id, 'plan_id' => $plan->id, 'statut' => 'active',
        'debut_periode' => now()->subMonth(), 'fin_periode' => now(),
    ]);

    $facture = app(BillingService::class)->facturer($abonnement);

    expect($facture->statut)->toBe('payee')
        ->and($facture->montant)->toEqual('29.00')
        ->and($facture->payee_le)->not->toBeNull();
});

test('un échec de paiement laisse la facture "impayee" SANS annuler son émission', function () {
    $this->app->bind(PaymentGateway::class, function () {
        return new class implements PaymentGateway {
            public function payer(float $montant, string $reference): void
            {
                throw new PaiementEchoueException('Carte refusée (test).');
            }
        };
    });

    $plan = Plan::create(['nom' => 'Pro', 'prix_mensuel' => 29.00, 'limite_projets' => 20]);
    $tenant = Tenant::create(['nom' => 'Acme']);
    $abonnement = Subscription::create([
        'tenant_id' => $tenant->id, 'plan_id' => $plan->id, 'statut' => 'active',
        'debut_periode' => now()->subMonth(), 'fin_periode' => now(),
    ]);

    $facture = app(BillingService::class)->facturer($abonnement);

    // Contrairement au tunnel d'achat (grand projet e-commerce), la facture
    // DOIT survivre à l'échec de paiement — c'est un comportement voulu,
    // testé explicitement pour ne jamais être "corrigé" par erreur.
    expect($facture->statut)->toBe('impayee')
        ->and(\App\Models\Invoice::count())->toBe(1);
});
