<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\Exceptions\PaiementEchoueException;

class FakePaymentGateway implements PaymentGateway
{
    public function payer(float $montant, string $reference): void
    {
        if ($montant <= 0) {
            throw new PaiementEchoueException("Montant invalide pour $reference.");
        }

        logger()->info("[Paiement simulé] {$montant}€ débités pour $reference.");
    }
}
