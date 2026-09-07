<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(CartService $panier): View
    {
        return view('cart.index', [
            'lignes' => $panier->lignesAvecProduits(),
            'total' => $panier->total(),
        ]);
    }

    public function ajouter(Request $request, Product $product, CartService $panier): RedirectResponse
    {
        $quantite = max(1, (int) $request->input('quantite', 1));

        if (!$product->estEnStock()) {
            return back()->with('erreur', 'Ce produit est en rupture de stock.');
        }

        $panier->ajouter($product, $quantite);

        return back()->with('succes', 'Produit ajouté au panier.');
    }

    public function retirer(Product $product, CartService $panier): RedirectResponse
    {
        $panier->retirer($product->id);

        return back()->with('succes', 'Produit retiré du panier.');
    }
}
