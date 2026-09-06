<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['annonce_id', 'expediteur_nom', 'expediteur_email', 'contenu'];

    public function annonce(): BelongsTo
    {
        return $this->belongsTo(Annonce::class);
    }
}
