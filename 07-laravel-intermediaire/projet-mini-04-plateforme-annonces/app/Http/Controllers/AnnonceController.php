<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnonceRequest;
use App\Http\Requests\UpdateAnnonceRequest;
use App\Models\Annonce;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnonceController extends Controller
{
    private const COLONNES_TRI_AUTORISEES = ['prix', 'created_at'];

    public function index(Request $request): View
    {
        $tri = in_array($request->input('tri'), self::COLONNES_TRI_AUTORISEES, true)
            ? $request->input('tri')
            : 'created_at';
        $ordre = $request->input('ordre') === 'asc' ? 'asc' : 'desc';

        $annonces = Annonce::query()
            ->with(['categorie', 'user']) // eager loading : module 07.1
            ->actives()
            ->when($request->filled('recherche'), function ($query) use ($request) {
                $query->where('titre', 'like', '%' . $request->input('recherche') . '%');
            })
            ->when($request->filled('categorie'), function ($query) use ($request) {
                $query->deLaCategorie((int) $request->input('categorie'));
            })
            ->when($request->filled('prix_max'), function ($query) use ($request) {
                $query->where('prix', '<=', $request->input('prix_max'));
            })
            ->orderBy($tri, $ordre)
            ->paginate(9)
            ->withQueryString();

        $categories = Category::orderBy('nom')->get();

        return view('annonces.index', compact('annonces', 'categories', 'tri', 'ordre'));
    }

    public function show(Annonce $annonce): View
    {
        $annonce->load(['categorie', 'user']);

        return view('annonces.show', compact('annonce'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('nom')->get();

        return view('annonces.create', compact('categories'));
    }

    public function store(StoreAnnonceRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('annonces', 'public');
        }

        $annonce = Annonce::create($data);

        return redirect()->route('annonces.show', $annonce)->with('succes', 'Annonce publiée.');
    }

    public function edit(Annonce $annonce): View
    {
        $this->authorize('update', $annonce);

        $categories = Category::orderBy('nom')->get();

        return view('annonces.edit', compact('annonce', 'categories'));
    }

    public function update(UpdateAnnonceRequest $request, Annonce $annonce): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($annonce->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($annonce->image);
            }
            $data['image'] = $request->file('image')->store('annonces', 'public');
        }

        $annonce->update($data);

        return redirect()->route('annonces.show', $annonce)->with('succes', 'Annonce modifiée.');
    }

    public function destroy(Annonce $annonce): RedirectResponse
    {
        $this->authorize('delete', $annonce);

        $annonce->delete(); // le Model Event "deleting" nettoie le fichier image (module 07.6)

        return redirect()->route('annonces.index')->with('succes', 'Annonce supprimée.');
    }
}
