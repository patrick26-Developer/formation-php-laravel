<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Annonce extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'categorie_id', 'titre', 'description', 'prix', 'image', 'active'];

    protected $casts = [
        'active' => 'boolean',
        'prix' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Les utilisateurs ayant mis cette annonce en favori (relation N-N).
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function scopeActives($query)
    {
        return $query->where('active', true);
    }

    public function scopeDeLaCategorie($query, int $categorieId)
    {
        return $query->where('categorie_id', $categorieId);
    }

    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image
                ? Storage::disk('public')->url($this->image)
                : null,
        );
    }

    /**
     * Nettoyage automatique du fichier image, quel que soit le point
     * d'entrée de la suppression (module 07.6, exercice 5).
     */
    protected static function booted(): void
    {
        static::deleting(function (Annonce $annonce) {
            if ($annonce->image) {
                Storage::disk('public')->delete($annonce->image);
            }
        });
    }
}
