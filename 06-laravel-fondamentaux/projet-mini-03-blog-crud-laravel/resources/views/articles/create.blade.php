@extends('layouts.app')

@section('titre', 'Nouvel article')

@section('contenu')
    <h1>Nouvel article</h1>

    <form method="POST" action="{{ route('articles.store') }}">
        @csrf
        @include('articles._form', ['article' => null])
        <button type="submit">Publier</button>
    </form>
@endsection
