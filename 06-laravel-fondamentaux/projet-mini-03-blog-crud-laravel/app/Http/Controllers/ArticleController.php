<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    private const COLONNES_TRI_AUTORISEES = ['titre', 'created_at'];

    /**
     * Liste publique des articles publiés, avec recherche, filtre par
     * catégorie, tri et pagination (module 06.7).
     */
    public function index(Request $request): View
    {
        $tri = in_array($request->input('tri'), self::COLONNES_TRI_AUTORISEES, true)
            ? $request->input('tri')
            : 'created_at';
        $ordre = $request->input('ordre') === 'asc' ? 'asc' : 'desc';

        $articles = Article::query()
            ->with('categorie') // eager loading : évite le problème N+1 (module 03.6) à l'affichage
            ->where('publie', true)
            ->when($request->filled('recherche'), function ($query) use ($request) {
                $query->where('titre', 'like', '%' . $request->input('recherche') . '%');
            })
            ->when($request->filled('categorie'), function ($query) use ($request) {
                $query->where('categorie_id', $request->input('categorie'));
            })
            ->orderBy($tri, $ordre)
            ->paginate(6)
            ->withQueryString();

        $categories = Category::orderBy('nom')->get();

        return view('articles.index', compact('articles', 'categories', 'tri', 'ordre'));
    }

    public function show(Article $article): View
    {
        $article->load(['categorie', 'comments' => fn ($q) => $q->latest()]);

        return view('articles.show', compact('article'));
    }

    /**
     * Les méthodes suivantes forment la partie "administration" du blog.
     * Volontairement non protégées par une authentification dans ce
     * mini-projet : la protection par connexion (Breeze) est introduite
     * au mini-projet du Niveau 07, qui reprend cette même base.
     */
    public function create(): View
    {
        $categories = Category::orderBy('nom')->get();

        return view('articles.create', compact('categories'));
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        Article::create($request->validated());

        return redirect()->route('articles.index')->with('succes', 'Article créé avec succès.');
    }

    public function edit(Article $article): View
    {
        $categories = Category::orderBy('nom')->get();

        return view('articles.edit', compact('article', 'categories'));
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update($request->validated());

        return redirect()->route('articles.index')->with('succes', 'Article modifié avec succès.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('articles.index')->with('succes', 'Article supprimé.');
    }
}
