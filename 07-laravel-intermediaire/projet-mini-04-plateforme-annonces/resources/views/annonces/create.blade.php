@extends('layouts.app')

@section('titre', 'Nouvelle annonce')

@section('contenu')
    <h1>Publier une annonce</h1>

    <form method="POST" action="{{ route('annonces.store') }}" enctype="multipart/form-data">
        @csrf
        @include('annonces._form', ['annonce' => null])
        <button type="submit">Publier</button>
    </form>
@endsection
