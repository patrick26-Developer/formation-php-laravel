<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->with('category')
            ->when($request->filled('recherche'), fn ($q) => $q->where('nom', 'like', '%' . $request->input('recherche') . '%'))
            ->when($request->filled('categorie'), fn ($q) => $q->where('category_id', $request->input('categorie')))
            ->orderBy($request->input('tri', 'nom'))
            ->paginate(12)
            ->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::orderBy('nom')->get(),
        ]);
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }
}
