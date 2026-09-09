# Solutions — 06.3 The Blade Templating Engine

## Exercise 1

```php
Route::get('/demo-echappement', function () {
    return view('demo', ['contenu' => "<script>alert('x')</script>"]);
});
```
```blade
{{-- resources/views/demo.blade.php --}}
<p>Escaped: {{ $contenu }}</p>
<p>Not escaped: {!! $contenu !!}</p>
```
The first literally displays the text `<script>alert('x')</script>` on screen (converted to HTML entities in the source code). The second actually runs the script in the browser — never do this with untrusted user data.

## Exercise 2

```blade
@if (empty($produits))
    <p>No products.</p>
@else
    <ul>
        @foreach ($produits as $produit)
            <li>{{ $produit['nom'] }} — {{ $produit['prix'] }} €</li>
        @endforeach
    </ul>
@endif
```

## Exercise 3

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
@section('titre', 'Home')
@section('contenu') <h1>Welcome</h1> @endsection
```
```blade
{{-- pages/contact.blade.php --}}
@extends('layouts.app')
@section('titre', 'Contact')
@section('contenu') <h1>Contact us</h1> @endsection
```

## Exercise 4

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
<x-carte titre="Product A">Description of product A.</x-carte>
<x-carte titre="Product B">Description of product B.</x-carte>
```

## Exercise 5

```blade
<form method="POST" action="/taches">
    @csrf
    <input type="text" name="titre" value="{{ old('titre') }}">
    @error('titre')
        <span class="erreur">{{ $message }}</span>
    @enderror
    <button type="submit">Create</button>
</form>
```
```php
public function store(Request $request)
{
    return back()->withErrors(['titre' => 'The title is required.'])->withInput();
}
```
`old('titre')` redisplays the previously entered value (thanks to `withInput()`), exactly like the [module 01.7](../../../01-php-fondamentaux/07-formulaires-http-get-post/README.en.md) form did manually with `htmlspecialchars($_POST['titre'] ?? '')`.
