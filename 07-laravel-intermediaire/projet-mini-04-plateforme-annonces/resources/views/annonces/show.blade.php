@extends('layouts.app')

@section('titre', $annonce->titre)

@section('contenu')
    <p><a href="{{ route('annonces.index') }}">← Retour aux annonces</a></p>

    @if ($annonce->image_url)
        <img src="{{ $annonce->image_url }}" alt="{{ $annonce->titre }}" width="400">
    @endif

    <h1>{{ $annonce->titre }}</h1>
    <p><strong>{{ number_format($annonce->prix, 2) }} €</strong> — {{ $annonce->categorie->nom }}</p>
    <p>Vendu par {{ $annonce->user->name }}</p>
    <div>{{ $annonce->description }}</div>

    @auth
        <form method="POST" action="{{ route('favoris.toggle', $annonce) }}">
            @csrf
            <button type="submit">
                {{ auth()->user()->favoris->contains($annonce) ? '★ Retirer des favoris' : '☆ Ajouter aux favoris' }}
            </button>
        </form>

        @can('update', $annonce)
            <a href="{{ route('annonces.edit', $annonce) }}">Modifier</a>
            <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" style="display:inline;">
                @csrf @method('DELETE')
                <button type="submit" onclick="return confirm('Supprimer cette annonce ?')">Supprimer</button>
            </form>
        @endcan
    @endauth

    <h2>Contacter le vendeur</h2>
    <form method="POST" action="{{ route('messages.store', $annonce) }}">
        @csrf
        <input type="text" name="expediteur_nom" placeholder="Votre nom" value="{{ old('expediteur_nom') }}" required>
        @error('expediteur_nom') <span style="color:red;">{{ $message }}</span> @enderror

        <input type="email" name="expediteur_email" placeholder="Votre email" value="{{ old('expediteur_email') }}" required>
        @error('expediteur_email') <span style="color:red;">{{ $message }}</span> @enderror

        <textarea name="contenu" placeholder="Votre message" required>{{ old('contenu') }}</textarea>
        @error('contenu') <span style="color:red;">{{ $message }}</span> @enderror

        <button type="submit">Envoyer</button>
    </form>
@endsection
