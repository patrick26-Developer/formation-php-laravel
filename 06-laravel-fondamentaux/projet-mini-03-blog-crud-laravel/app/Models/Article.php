<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['categorie_id', 'titre', 'slug', 'contenu', 'publie'];

    protected $casts = [
        'publie' => 'boolean',
    ];

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
