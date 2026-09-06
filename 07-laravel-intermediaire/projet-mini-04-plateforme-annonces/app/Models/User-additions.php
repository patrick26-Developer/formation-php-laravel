<?php

/**
 * Ce fichier n'est PAS un fichier à copier tel quel : il documente les
 * ajouts à faire dans le app/Models/User.php généré par Breeze
 * (voir INSTALLATION.md). Breeze génère déjà la classe User de base ;
 * on y ajoute simplement les relations propres à ce projet.
 */

use App\Models\Annonce;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable; // déjà présent par défaut dans Breeze

// À ajouter DANS la classe User existante :

public function annonces(): HasMany
{
    return $this->hasMany(Annonce::class);
}

public function favoris(): BelongsToMany
{
    return $this->belongsToMany(Annonce::class, 'favorites')->withTimestamps();
}
