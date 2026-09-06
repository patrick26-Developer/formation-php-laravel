<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Annonce;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Annonce $annonce): RedirectResponse
    {
        $utilisateur = $request->user();

        if ($utilisateur->favoris()->where('annonce_id', $annonce->id)->exists()) {
            $utilisateur->favoris()->detach($annonce->id);
        } else {
            $utilisateur->favoris()->attach($annonce->id);
        }

        return back();
    }
}
