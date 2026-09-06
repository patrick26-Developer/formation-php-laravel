<?php

/**
 * Ajouts à faire dans app/Models/User.php généré par Breeze
 * (voir INSTALLATION.md) : 'tenant_id' dans $fillable, et la relation.
 */

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// $fillable = ['name', 'email', 'password', 'tenant_id'];

public function tenant(): BelongsTo
{
    return $this->belongsTo(Tenant::class);
}
