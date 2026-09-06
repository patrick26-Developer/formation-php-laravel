<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Le scope global sur Project (module 08.5) empêche déjà un utilisateur
     * de CHARGER un projet d'un autre tenant via {project} dans une route.
     * Cette Policy reste une seconde ligne de défense explicite : si un jour
     * le scope est retiré ou contourné, cette vérification protège encore.
     */
    public function view(User $user, Project $project): bool
    {
        return $user->tenant_id === $project->tenant_id;
    }

    public function update(User $user, Project $project): bool
    {
        return $user->tenant_id === $project->tenant_id;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->tenant_id === $project->tenant_id;
    }
}
