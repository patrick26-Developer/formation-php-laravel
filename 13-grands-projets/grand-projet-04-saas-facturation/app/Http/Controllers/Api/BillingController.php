<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function abonnement(Request $request)
    {
        $abonnement = $request->user()->tenant->abonnementActif()->with('plan')->first();

        if ($abonnement === null) {
            return response()->json(['message' => 'Aucun abonnement actif.'], 404);
        }

        return response()->json([
            'plan' => $abonnement->plan->nom,
            'prix_mensuel' => (float) $abonnement->plan->prix_mensuel,
            'fin_periode' => $abonnement->fin_periode->toIso8601String(),
        ]);
    }

    public function factures(Request $request)
    {
        $factures = $request->user()->tenant
            ->subscriptions()
            ->with('invoices')
            ->get()
            ->pluck('invoices')
            ->flatten();

        return response()->json($factures->map(fn ($f) => [
            'id' => $f->id,
            'montant' => (float) $f->montant,
            'statut' => $f->statut,
            'emise_le' => $f->emise_le->toIso8601String(),
        ]));
    }
}
