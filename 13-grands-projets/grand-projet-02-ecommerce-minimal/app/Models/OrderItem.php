<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    public $timestamps = false;

    protected $fillable = ['order_id', 'product_id', 'nom_produit', 'prix_unitaire', 'quantite'];

    protected $casts = [
        'prix_unitaire' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sousTotal(): float
    {
        return (float) $this->prix_unitaire * $this->quantite;
    }
}
