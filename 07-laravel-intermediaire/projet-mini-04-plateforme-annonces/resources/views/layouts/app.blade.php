<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('titre', 'Petites Annonces')</title>
</head>
<body>
    <nav>
        <a href="{{ route('annonces.index') }}">Annonces</a>
        @auth
            <a href="{{ route('annonces.create') }}">+ Déposer une annonce</a>
            <span>{{ auth()->user()->name }} ({{ auth()->user()->unreadNotifications->count() }} notification(s))</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit">Déconnexion</button>
            </form>
        @else
            <a href="{{ route('login') }}">Connexion</a>
            <a href="{{ route('register') }}">Inscription</a>
        @endauth
    </nav>

    @if (session('succes'))
        <p style="color:green;">{{ session('succes') }}</p>
    @endif

    <main>
        @yield('contenu')
    </main>
</body>
</html>
