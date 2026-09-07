<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Exceptions\PaiementEchoueException;

/**
 * Passerelle de paiement SIMULÉE : aucune vraie transaction financière.
 * Le rôle pédagogique de cette classe est de démontrer le pattern
 * Strategy + inversion de dépendance (module 08.4) : remplacer cette
 * implémentation par "StripeGateway" en production ne demanderait qu'un
 * changement dans AppServiceProvider::register(), aucun contrôleur
 * n'aurait à être modifié.
 */
class FakePaymentGateway implements PaymentGateway
{
    public function payer(float $montant, string $referenceCommande): void
    {
        // Simule un échec pour tout montant negatif ou nul — permet de
        // tester le chemin d'échec sans dépendre d'un vrai prestataire.
        if ($montant <= 0) {
            throw new PaiementEchoueException("Montant invalide pour la commande $referenceCommande.");
        }

        logger()->info("[Paiement simulé] {$montant}€ débités pour la commande $referenceCommande.");
    }
}
