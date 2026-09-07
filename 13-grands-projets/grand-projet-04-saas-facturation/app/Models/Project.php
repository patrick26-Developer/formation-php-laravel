<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'nom'];

    /**
     * Isolation multi-tenant identique au mini-projet du niveau 08 :
     * scope global filtrant automatiquement par tenant de l'utilisateur
     * connecté, doublé d'une assignation automatique à la création.
     */
    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check() && auth()->user()->tenant_id !== null) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });

        static::creating(function (Project $project) {
            $project->tenant_id ??= auth()->user()?->tenant_id;
        });
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
