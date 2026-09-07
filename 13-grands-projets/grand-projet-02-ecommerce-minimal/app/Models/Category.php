<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    public $timestamps = false;

    protected $fillable = ['nom', 'slug'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
