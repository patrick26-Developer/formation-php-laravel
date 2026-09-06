# 06.3 — Le moteur de templates Blade

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Utiliser la syntaxe Blade pour l'affichage et les structures de contrôle.
- Construire des layouts réutilisables avec héritage de templates.
- Créer et utiliser des composants Blade.
- Comprendre l'échappement automatique de Blade.

## 📋 Prérequis

[06.2 — Routing et Controllers](../02-routing-controllers/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Affichage et échappement automatique

```blade
<h1>{{ $tache->titre }}</h1>
```

> 💡 **Différence essentielle avec le PHP natif** : `{{ }}` appelle `htmlspecialchars()` **automatiquement**. Vous avez appliqué cette règle manuellement à chaque `echo` depuis le [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.md) — Blade l'impose par défaut, rendant une faille XSS (module 02.6) beaucoup plus difficile à introduire par erreur.

```blade
{{-- Pour afficher du HTML brut volontairement (rare, à utiliser avec prudence) --}}
{!! $contenuHtmlDeConfiance !!}
```

### Structures de contrôle

```blade
@if ($taches->isEmpty())
    <p>Aucune tâche.</p>
@else
    <ul>
        @foreach ($taches as $tache)
            <li>{{ $tache->titre }} — {{ $tache->terminee ? '✅' : '🕓' }}</li>
        @endforeach
    </ul>
@endif

@auth
    <p>Bonjour, {{ auth()->user()->name }}</p>
@endauth
```

> 📌 Reconnaissez le `<?php foreach (...): ?>` / `<?php endforeach; ?>` de votre [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.md) : `@foreach`/`@endforeach` en est simplement une syntaxe raccourcie, compilée en PHP classique en coulisse.

### Héritage de layouts

`resources/views/layouts/app.blade.php` :
```blade
<!DOCTYPE html>
<html lang="fr">
<head>
    <title>@yield('titre', 'Mon Application')</title>
</head>
<body>
    <nav>...</nav>

    <main>
        @yield('contenu')
    </main>
</body>
</html>
```

`resources/views/taches/index.blade.php` :
```blade
@extends('layouts.app')

@section('titre', 'Mes tâches')

@section('contenu')
    <h1>Mes tâches</h1>
    @foreach ($taches as $tache)
        <p>{{ $tache->titre }}</p>
    @endforeach
@endsection
```

> 💡 C'est le même principe que `Vue::afficher()` avec `header.php`/`footer.php` du [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.md), mais avec une syntaxe dédiée : `@extends` déclare le layout parent, `@section`/`@endsection` remplissent ses zones (`@yield`).

### Les composants Blade : factoriser des blocs réutilisables

```bash
php artisan make:component Alerte
```

`resources/views/components/alerte.blade.php` :
```blade
<div class="alerte alerte-{{ $type }}">
    {{ $slot }}
</div>
```

Utilisation dans n'importe quelle vue :
```blade
<x-alerte type="danger">
    Une erreur est survenue !
</x-alerte>
```

### Directives utiles

```blade
@csrf                          {{-- injecte le jeton CSRF (module 02.6), automatique dans un <form> --}}
@method('PUT')                  {{-- simule PUT/DELETE dans un formulaire HTML (qui ne supporte que GET/POST) --}}

@error('titre')
    <span class="erreur">{{ $message }}</span>
@enderror

{{-- Boucle avec informations sur l'itération --}}
@foreach ($taches as $tache)
    {{ $loop->index }} : {{ $tache->titre }}
    @if ($loop->last) (dernière tâche) @endif
@endforeach
```

> 📌 `@csrf` automatise exactement le jeton caché que vous génériez à la main avec `CsrfHelper::jeton()` au [mini-projet du niveau 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md).

## ✅ Points clés à retenir

- `{{ }}` échappe automatiquement (équivalent à `htmlspecialchars()`) ; `{!! !!}` n'échappe pas, à réserver à du contenu de confiance.
- `@extends`/`@section`/`@yield` implémentent l'héritage de layout, remplaçant les inclusions manuelles de header/footer.
- Les composants Blade (`<x-nom-composant>`) factorisent des blocs d'interface réutilisables.
- `@csrf` et `@method('PUT')` automatisent des mécaniques que vous avez déjà écrites à la main en PHP natif.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Blade Templates](https://laravel.com/docs/blade)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [06.2 — Routing et Controllers](../02-routing-controllers/README.md) · **Suite :** [06.4 — Eloquent ORM : les bases](../04-eloquent-orm-bases/README.md)
