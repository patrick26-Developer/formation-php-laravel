<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('articles')->orderBy('nom')->get();

        return view('categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:categories,slug', 'alpha_dash'],
        ]);

        Category::create($data);

        return redirect()->route('categories.index')->with('succes', 'Catégorie créée.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete(); // cascadeOnDelete() supprime aussi ses articles

        return redirect()->route('categories.index')->with('succes', 'Catégorie supprimée.');
    }
}
