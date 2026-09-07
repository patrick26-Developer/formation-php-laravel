<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public $timestamps = false;

    protected $fillable = ['nom', 'prix_mensuel', 'limite_projets'];

    public function estIllimite(): bool
    {
        return $this->limite_projets === 0;
    }
}
