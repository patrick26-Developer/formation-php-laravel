@extends('layouts.app')

@section('titre', 'Catégories')

@section('contenu')
    <h1>Catégories</h1>

    <ul>
        @foreach ($categories as $categorie)
            <li>
                {{ $categorie->nom }} ({{ $categorie->articles_count }} article(s))
                <form method="POST" action="{{ route('categories.destroy', $categorie) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Supprimer cette catégorie et TOUS ses articles ?')">Supprimer</button>
                </form>
            </li>
        @endforeach
    </ul>

    <h2>Nouvelle catégorie</h2>
    <form method="POST" action="{{ route('categories.store') }}">
        @csrf
        <input type="text" name="nom" placeholder="Nom" value="{{ old('nom') }}" required>
        <input type="text" name="slug" placeholder="slug-de-la-categorie" value="{{ old('slug') }}" required>
        <button type="submit">Créer</button>
    </form>
@endsection
