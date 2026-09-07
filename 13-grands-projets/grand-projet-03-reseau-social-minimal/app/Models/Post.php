<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'contenu'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function estAimeParL(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        // ->loaded('likedBy') évite une requête N+1 si la relation a déjà
        // été chargée en amont (module 07.1) ; sinon, retombe sur une
        // requête ciblée unique.
        if ($this->relationLoaded('likedBy')) {
            return $this->likedBy->contains($user);
        }

        return $this->likedBy()->where('users.id', $user->id)->exists();
    }
}
