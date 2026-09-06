@extends('layouts.app')

@section('titre', 'Modifier l\'annonce')

@section('contenu')
    <h1>Modifier l'annonce</h1>

    <form method="POST" action="{{ route('annonces.update', $annonce) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('annonces._form')
        <button type="submit">Enregistrer</button>
    </form>
@endsection
