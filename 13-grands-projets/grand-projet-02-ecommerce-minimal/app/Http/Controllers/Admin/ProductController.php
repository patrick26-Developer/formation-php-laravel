<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

/**
 * Toutes les méthodes de ce contrôleur sont protégées par le Gate
 * "acceder-admin" (module 07.5), appliqué au niveau du groupe de routes
 * plutôt que répété dans chaque méthode.
 */
class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.products.index', ['products' => Product::with('category')->latest()->paginate(20)]);
    }

    public function create(): View
    {
        return view('admin.products.create', ['categories' => Category::orderBy('nom')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nom' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $data['slug'] = Str::slug($data['nom']) . '-' . uniqid();

        Product::create($data);

        return redirect()->route('admin.products.index')->with('succes', 'Produit créé.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', ['product' => $product, 'categories' => Category::orderBy('nom')->get()]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'nom' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string'],
            'prix' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('succes', 'Produit modifié.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')->with('succes', 'Produit supprimé.');
    }
}
