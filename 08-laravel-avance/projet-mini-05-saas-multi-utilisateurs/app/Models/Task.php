<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'titre', 'terminee'];

    protected $casts = ['terminee' => 'boolean'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
