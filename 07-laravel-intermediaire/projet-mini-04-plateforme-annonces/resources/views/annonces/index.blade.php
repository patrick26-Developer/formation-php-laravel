@extends('layouts.app')

@section('titre', 'Petites annonces')

@section('contenu')
    <h1>Annonces</h1>

    <form method="GET">
        <input type="text" name="recherche" placeholder="Rechercher..." value="{{ request('recherche') }}">
        <select name="categorie">
            <option value="">Toutes les catégories</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}" @selected(request('categorie') == $categorie->id)>{{ $categorie->nom }}</option>
            @endforeach
        </select>
        <input type="number" name="prix_max" placeholder="Prix max" value="{{ request('prix_max') }}">
        <button type="submit">Filtrer</button>
    </form>

    <p>
        Trier par :
        <a href="{{ request()->fullUrlWithQuery(['tri' => 'prix', 'ordre' => $tri === 'prix' && $ordre === 'asc' ? 'desc' : 'asc']) }}">Prix</a>
        |
        <a href="{{ request()->fullUrlWithQuery(['tri' => 'created_at', 'ordre' => $tri === 'created_at' && $ordre === 'asc' ? 'desc' : 'asc']) }}">Date</a>
    </p>

    <div>
        @forelse ($annonces as $annonce)
            <div>
                @if ($annonce->image_url)
                    <img src="{{ $annonce->image_url }}" alt="{{ $annonce->titre }}" width="150">
                @endif
                <h3><a href="{{ route('annonces.show', $annonce) }}">{{ $annonce->titre }}</a></h3>
                <p>{{ number_format($annonce->prix, 2) }} € — {{ $annonce->categorie->nom }}</p>
                <p><small>Par {{ $annonce->user->name }}</small></p>
            </div>
        @empty
            <p>Aucune annonce ne correspond à votre recherche.</p>
        @endforelse
    </div>

    {{ $annonces->links() }}
@endsection
