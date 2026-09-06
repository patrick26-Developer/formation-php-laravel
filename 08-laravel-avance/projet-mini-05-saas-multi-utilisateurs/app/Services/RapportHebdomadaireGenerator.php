<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\RapportGenerator;
use App\Models\Task;
use App\Models\Tenant;

/**
 * Implémentation par défaut de RapportGenerator (module 08.4 : lier une
 * interface à une implémentation). Un futur "RapportPdfGenerator" pourrait
 * la remplacer sans qu'aucun contrôleur/Job n'ait à changer.
 */
class RapportHebdomadaireGenerator implements RapportGenerator
{
    public function genererPourTenant(Tenant $tenant): array
    {
        // withoutGlobalScope : un rapport interne doit voir TOUS les projets
        // du tenant, peu importe qui (ou si quelqu'un) est authentifié au
        // moment de l'exécution du Job en arrière-plan (module 08.1).
        $projets = $tenant->projects()->withoutGlobalScope('tenant')->get();
        $projetsActifs = $projets->where('actif', true)->count();

        $idsProjets = $projets->pluck('id');
        $tachesTotales = Task::whereIn('project_id', $idsProjets)->count();
        $tachesTerminees = Task::whereIn('project_id', $idsProjets)->where('terminee', true)->count();

        return [
            'tenant' => $tenant->nom,
            'projets_actifs' => $projetsActifs,
            'taches_terminees' => $tachesTerminees,
            'taches_totales' => $tachesTotales,
        ];
    }
}
