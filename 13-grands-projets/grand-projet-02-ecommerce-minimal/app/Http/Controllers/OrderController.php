<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\PaiementEchoueException;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function valider(Request $request, OrderService $orderService, CartService $panier): RedirectResponse
    {
        try {
            $commande = $orderService->passerCommande($request->user(), $panier);
        } catch (\InvalidArgumentException $e) {
            return back()->with('erreur', $e->getMessage());
        } catch (PaiementEchoueException $e) {
            return back()->with('erreur', 'Le paiement a échoué : ' . $e->getMessage());
        }

        return redirect()->route('orders.confirmation', $commande)->with('succes', 'Commande validée !');
    }

    public function confirmation(\App\Models\Order $order): View
    {
        $this->authorize('view', $order);

        return view('orders.confirmation', compact('order'));
    }

    public function historique(Request $request): View
    {
        $commandes = $request->user()->orders()->with('items')->latest()->paginate(10);

        return view('orders.historique', compact('commandes'));
    }
}
