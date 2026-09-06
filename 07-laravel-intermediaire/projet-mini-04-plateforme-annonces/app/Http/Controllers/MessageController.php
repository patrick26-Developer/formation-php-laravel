<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Notifications\NouveauMessageNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Annonce $annonce): RedirectResponse
    {
        $data = $request->validate([
            'expediteur_nom' => ['required', 'string', 'max:100'],
            'expediteur_email' => ['required', 'email'],
            'contenu' => ['required', 'string', 'max:2000'],
        ]);

        $message = $annonce->messages()->create($data);

        $annonce->user->notify(new NouveauMessageNotification($message));

        return redirect()
            ->route('annonces.show', $annonce)
            ->with('succes', 'Votre message a été envoyé au vendeur.');
    }
}
