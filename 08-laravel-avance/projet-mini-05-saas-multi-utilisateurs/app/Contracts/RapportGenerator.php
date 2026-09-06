<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Tenant;

interface RapportGenerator
{
    /**
     * @return array{tenant: string, projets_actifs: int, taches_terminees: int, taches_totales: int}
     */
    public function genererPourTenant(Tenant $tenant): array;
}
