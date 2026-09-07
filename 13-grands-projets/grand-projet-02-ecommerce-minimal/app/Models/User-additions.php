<?php

/**
 * Ajouts à faire dans app/Models/User.php généré par Breeze :
 * une colonne "est_admin" (migration à ajouter, comme au module 10.4)
 * et la relation vers les commandes.
 */

use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\HasMany;

public function orders(): HasMany
{
    return $this->hasMany(Order::class);
}
