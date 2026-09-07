<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'nom', 'slug', 'description', 'prix', 'stock', 'image'];

    protected $casts = [
        'prix' => 'decimal:2',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeEnStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function estEnStock(): bool
    {
        return $this->stock > 0;
    }
}
