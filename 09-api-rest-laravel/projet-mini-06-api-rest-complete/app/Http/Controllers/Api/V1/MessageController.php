<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\MessageResource;
use App\Models\Annonce;
use App\Notifications\NouveauMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function store(Request $request, Annonce $annonce)
    {
        $data = $request->validate([
            'expediteur_nom' => ['required', 'string', 'max:100'],
            'expediteur_email' => ['required', 'email'],
            'contenu' => ['required', 'string', 'max:2000'],
        ]);

        $message = $annonce->messages()->create($data);

        $annonce->user->notify(new NouveauMessageNotification($message));

        return (new MessageResource($message))->response()->setStatusCode(Response::HTTP_CREATED);
    }
}
