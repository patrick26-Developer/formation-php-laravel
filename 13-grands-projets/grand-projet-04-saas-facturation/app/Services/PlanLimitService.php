<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\LimitePlanAtteinteException;
use App\Models\Tenant;

/**
 * Centralise TOUTE la logique de vérification de plan : le seul endroit
 * à modifier si un jour une nouvelle limite (nombre d'utilisateurs, de
 * stockage...) doit être vérifiée pour un tenant.
 */
class PlanLimitService
{
    public function verifierLimiteProjets(Tenant $tenant): void
    {
        $abonnement = $tenant->abonnementActif;

        if ($abonnement === null) {
            throw new LimitePlanAtteinteException('Aucun abonnement actif pour cette organisation.');
        }

        $plan = $abonnement->plan;

        if ($plan->estIllimite()) {
            return;
        }

        $nombreProjetsActuels = $tenant->projects()->withoutGlobalScope('tenant')->count();

        if ($nombreProjetsActuels >= $plan->limite_projets) {
            throw new LimitePlanAtteinteException(
                "Limite du plan \"{$plan->nom}\" atteinte ({$plan->limite_projets} projets). Passez à un plan supérieur pour continuer."
            );
        }
    }
}
