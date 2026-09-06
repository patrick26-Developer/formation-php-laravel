<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Annonce;
use App\Models\User;

class AnnoncePolicy
{
    public function update(User $user, Annonce $annonce): bool
    {
        return $user->id === $annonce->user_id;
    }

    public function delete(User $user, Annonce $annonce): bool
    {
        return $user->id === $annonce->user_id;
    }
}
