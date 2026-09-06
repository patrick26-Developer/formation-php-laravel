<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'nom', 'description', 'actif'];

    protected $casts = ['actif' => 'boolean'];

    /**
     * Isolation multi-tenant (module 08.5) : TOUTE requête Eloquent sur
     * Project est automatiquement restreinte au tenant de l'utilisateur
     * connecté. Un développeur qui oublierait ce filtre dans un contrôleur
     * reste protégé grâce à ce scope global.
     *
     * ⚠️ Ce scope ne protège PAS une requête Query Builder brute
     * (DB::table('projects')) : voir module 08.5, exercice 4.
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

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function scopeActifs($query)
    {
        return $query->where('actif', true);
    }
}
