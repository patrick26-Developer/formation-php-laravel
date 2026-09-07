<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Services\BillingService;
use Illuminate\Console\Command;

class FacturerAbonnementsCommand extends Command
{
    protected $signature = 'facturation:executer';

    protected $description = 'Émet une facture pour chaque abonnement actif dont la période se termine aujourd\'hui.';

    public function handle(BillingService $billingService): int
    {
        $abonnements = Subscription::query()
            ->where('statut', 'active')
            ->whereDate('fin_periode', '<=', now())
            ->get();

        $this->info("{$abonnements->count()} abonnement(s) à facturer.");

        foreach ($abonnements as $abonnement) {
            $facture = $billingService->facturer($abonnement);

            $this->line("Tenant #{$abonnement->tenant_id} : facture #{$facture->id} — {$facture->statut}");
        }

        return self::SUCCESS;
    }
}
