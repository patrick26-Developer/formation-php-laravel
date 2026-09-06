<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['nom', 'slug'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'categorie_id');
    }
}
