<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('titre', 'Mon Blog')</title>
</head>
<body>
    <nav>
        <a href="{{ route('articles.index') }}">Articles</a>
        <a href="{{ route('categories.index') }}">Catégories</a>
        <a href="{{ route('articles.create') }}">+ Nouvel article</a>
    </nav>

    @if (session('succes'))
        <p style="color:green;">{{ session('succes') }}</p>
    @endif

    <main>
        @yield('contenu')
    </main>
</body>
</html>
