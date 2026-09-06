@extends('layouts.app')

@section('titre', 'Modifier l\'article')

@section('contenu')
    <h1>Modifier l'article</h1>

    <form method="POST" action="{{ route('articles.update', $article) }}">
        @csrf
        @method('PUT')
        @include('articles._form')
        <button type="submit">Enregistrer</button>
    </form>
@endsection
