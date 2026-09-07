<?php

declare(strict_types=1);

namespace App\Contracts;

interface PaymentGateway
{
    /**
     * @throws \App\Exceptions\PaiementEchoueException
     */
    public function payer(float $montant, string $reference): void;
}
