<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\NouvelAbonneNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function basculer(Request $request, User $user): RedirectResponse
    {
        $utilisateurConnecte = $request->user();

        if ($utilisateurConnecte->id === $user->id) {
            return back()->with('erreur', 'Vous ne pouvez pas vous suivre vous-même.');
        }

        if ($utilisateurConnecte->suit($user)) {
            $utilisateurConnecte->following()->detach($user->id);
        } else {
            $utilisateurConnecte->following()->attach($user->id);
            $user->notify(new NouvelAbonneNotification($utilisateurConnecte));
        }

        return back();
    }
}
