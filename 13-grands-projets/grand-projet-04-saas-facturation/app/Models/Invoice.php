<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    public $timestamps = false;

    protected $fillable = ['subscription_id', 'montant', 'statut', 'emise_le', 'payee_le'];

    protected $casts = [
        'montant' => 'decimal:2',
        'emise_le' => 'datetime',
        'payee_le' => 'datetime',
    ];

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }
}
