@extends('layouts.app')

@section('titre', $article->titre)

@section('contenu')
    <p><a href="{{ route('articles.index') }}">← Retour aux articles</a></p>

    <article>
        <h1>{{ $article->titre }}</h1>
        <p><em>{{ $article->categorie->nom }}</em> — {{ $article->created_at->format('d/m/Y') }}</p>
        <div>{{ $article->contenu }}</div>
    </article>

    <p>
        <a href="{{ route('articles.edit', $article) }}">Modifier</a>
        |
        <form method="POST" action="{{ route('articles.destroy', $article) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
        </form>
    </p>

    <h2>Commentaires ({{ $article->comments->count() }})</h2>

    @foreach ($article->comments as $commentaire)
        <div>
            <strong>{{ $commentaire->nom_auteur }}</strong> — {{ $commentaire->created_at->diffForHumans() }}
            <p>{{ $commentaire->contenu }}</p>
        </div>
    @endforeach

    <h3>Laisser un commentaire</h3>
    <form method="POST" action="{{ route('comments.store', $article) }}">
        @csrf
        <input type="text" name="nom_auteur" placeholder="Votre nom" value="{{ old('nom_auteur') }}" required>
        @error('nom_auteur') <span style="color:red;">{{ $message }}</span> @enderror

        <textarea name="contenu" placeholder="Votre commentaire" required>{{ old('contenu') }}</textarea>
        @error('contenu') <span style="color:red;">{{ $message }}</span> @enderror

        <button type="submit">Publier</button>
    </form>
@endsection
