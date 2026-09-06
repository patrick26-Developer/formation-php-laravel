<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Contracts\RapportGenerator;
use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenererRapportHebdomadaire implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public function __construct(public Tenant $tenant)
    {
    }

    /**
     * RapportGenerator est injecté automatiquement par le Service Container
     * (module 08.4), même dans un Job traité en arrière-plan par un worker.
     */
    public function handle(RapportGenerator $generateur): void
    {
        $rapport = $generateur->genererPourTenant($this->tenant);

        logger()->info('Rapport hebdomadaire généré', $rapport);

        // Dans une vraie application : Mail::to($destinataires)->send(new RapportMail($rapport));
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error("Échec de la génération du rapport pour le tenant {$this->tenant->id}", [
            'erreur' => $exception->getMessage(),
        ]);
    }
}
