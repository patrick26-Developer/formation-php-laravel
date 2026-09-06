@extends('layouts.app')

@section('titre', 'Articles')

@section('contenu')
    <h1>Articles</h1>

    <form method="GET">
        <input type="text" name="recherche" placeholder="Rechercher..." value="{{ request('recherche') }}">

        <select name="categorie">
            <option value="">Toutes les catégories</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(request('categorie') == $categorie->id)>
                    {{ $categorie->nom }}
                </option>
            @endforeach
        </select>

        <button type="submit">Filtrer</button>
    </form>

    <p>
        Trier par :
        <a href="{{ request()->fullUrlWithQuery(['tri' => 'titre', 'ordre' => $tri === 'titre' && $ordre === 'asc' ? 'desc' : 'asc']) }}">Titre</a>
        |
        <a href="{{ request()->fullUrlWithQuery(['tri' => 'created_at', 'ordre' => $tri === 'created_at' && $ordre === 'asc' ? 'desc' : 'asc']) }}">Date</a>
    </p>

    @forelse ($articles as $article)
        <article>
            <h2><a href="{{ route('articles.show', $article) }}">{{ $article->titre }}</a></h2>
            <p><em>{{ $article->categorie->nom }}</em> — {{ $article->created_at->format('d/m/Y') }}</p>
        </article>
    @empty
        <p>Aucun article trouvé.</p>
    @endforelse

    {{ $articles->links() }}
@endsection
