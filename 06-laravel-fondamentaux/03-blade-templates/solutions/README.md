# Solutions — 06.3 Le moteur de templates Blade

## Exercice 1

```php
Route::get('/demo-echappement', function () {
    return view('demo', ['contenu' => "<script>alert('x')</script>"]);
});
```
```blade
{{-- resources/views/demo.blade.php --}}
<p>Échappé : {{ $contenu }}</p>
<p>Non échappé : {!! $contenu !!}</p>
```
Le premier affiche littéralement le texte `<script>alert('x')</script>` à l'écran (converti en entités HTML dans le code source). Le second exécute réellement le script dans le navigateur — à ne jamais faire avec une donnée utilisateur non fiable.

## Exercice 2

```blade
@if (empty($produits))
    <p>Aucun produit.</p>
@else
    <ul>
        @foreach ($produits as $produit)
            <li>{{ $produit['nom'] }} — {{ $produit['prix'] }} €</li>
        @endforeach
    </ul>
@endif
```

## Exercice 3

```blade
{{-- layouts/app.blade.php --}}
<!DOCTYPE html>
<html>
<head><title>@yield('titre')</title></head>
<body>@yield('contenu')</body>
</html>
```
```blade
{{-- pages/accueil.blade.php --}}
@extends('layouts.app')
@section('titre', 'Accueil')
@section('contenu') <h1>Bienvenue</h1> @endsection
```
```blade
{{-- pages/contact.blade.php --}}
@extends('layouts.app')
@section('titre', 'Contact')
@section('contenu') <h1>Contactez-nous</h1> @endsection
```

## Exercice 4

```bash
php artisan make:component Carte
```
```blade
{{-- components/carte.blade.php --}}
@props(['titre'])
<div style="border: 1px solid #ccc; padding: 1rem;">
    <h3>{{ $titre }}</h3>
    {{ $slot }}
</div>
```
```blade
<x-carte titre="Produit A">Description du produit A.</x-carte>
<x-carte titre="Produit B">Description du produit B.</x-carte>
```

## Exercice 5

```blade
<form method="POST" action="/taches">
    @csrf
    <input type="text" name="titre" value="{{ old('titre') }}">
    @error('titre')
        <span class="erreur">{{ $message }}</span>
    @enderror
    <button type="submit">Créer</button>
</form>
```
```php
public function store(Request $request)
{
    return back()->withErrors(['titre' => 'Le titre est requis.'])->withInput();
}
```
`old('titre')` réaffiche la valeur précédemment saisie (grâce à `withInput()`), exactement comme le faisait manuellement le formulaire du [module 01.7](../../../01-php-fondamentaux/07-formulaires-http-get-post/README.md) avec `htmlspecialchars($_POST['titre'] ?? '')`.
