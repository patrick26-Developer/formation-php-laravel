<?php

/**
 * Ajouts à faire dans app/Models/User.php généré par Breeze : les
 * relations auto-référencées "follows" (module 07.1) et les publications.
 */

use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

public function posts(): HasMany
{
    return $this->hasMany(Post::class);
}

/**
 * Les utilisateurs que CET utilisateur suit.
 */
public function following(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')->withTimestamps();
}

/**
 * Les utilisateurs qui suivent CET utilisateur.
 */
public function followers(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id')->withTimestamps();
}

public function suit(User $autre): bool
{
    return $this->following()->where('followed_id', $autre->id)->exists();
}
