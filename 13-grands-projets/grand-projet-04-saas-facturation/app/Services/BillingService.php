<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Exceptions\PaiementEchoueException;
use App\Models\Invoice;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;

/**
 * Orchestre la facturation périodique : émission d'une facture, tentative
 * de paiement automatique, et mise à jour du statut — le même principe
 * transactionnel que OrderService du grand projet e-commerce (module 04.2),
 * appliqué ici à un cycle d'abonnement plutôt qu'à un achat ponctuel.
 */
class BillingService
{
    public function __construct(private readonly PaymentGateway $paymentGateway)
    {
    }

    public function facturer(Subscription $abonnement): Invoice
    {
        return DB::transaction(function () use ($abonnement) {
            $facture = Invoice::create([
                'subscription_id' => $abonnement->id,
                'montant' => $abonnement->plan->prix_mensuel,
                'statut' => 'impayee',
                'emise_le' => now(),
            ]);

            try {
                $this->paymentGateway->payer((float) $facture->montant, "abonnement-{$abonnement->id}-facture-{$facture->id}");
            } catch (PaiementEchoueException) {
                // Contrairement au tunnel d'achat du projet e-commerce, un
                // échec de paiement d'abonnement NE DOIT PAS annuler la
                // facture : elle doit rester "impayee" et visible, pour
                // permettre une relance — décision métier différente,
                // donc PAS de rollback ici malgré la transaction ouverte.
                return $facture;
            }

            $facture->update(['statut' => 'payee', 'payee_le' => now()]);

            return $facture->fresh();
        });
    }
}
