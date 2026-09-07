# 06.3 — The Blade Templating Engine

> **Status:** ✅ Available

## 🎯 Objectives

- Use Blade syntax for output and control structures.
- Build reusable layouts with template inheritance.
- Create and use Blade components.
- Understand Blade's automatic escaping.

## 📋 Prerequisites

[06.2 — Routing and Controllers](../02-routing-controllers/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Output and automatic escaping

```blade
<h1>{{ $tache->titre }}</h1>
```

> 💡 **Key difference from native PHP**: `{{ }}` calls `htmlspecialchars()` **automatically**. You've been applying this rule manually on every `echo` since [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.en.md) — Blade enforces it by default, making an XSS flaw (module 02.6) much harder to introduce by mistake.

```blade
{{-- To deliberately output raw HTML (rare, use with caution) --}}
{!! $trustedHtmlContent !!}
```

### Control structures

```blade
@if ($taches->isEmpty())
    <p>No tasks.</p>
@else
    <ul>
        @foreach ($taches as $tache)
            <li>{{ $tache->titre }} — {{ $tache->terminee ? '✅' : '🕓' }}</li>
        @endforeach
    </ul>
@endif

@auth
    <p>Hello, {{ auth()->user()->name }}</p>
@endauth
```

> 📌 Recognize the `<?php foreach (...): ?>` / `<?php endforeach; ?>` from your [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.en.md): `@foreach`/`@endforeach` is simply a shorthand syntax for it, compiled into plain PHP under the hood.

### Layout inheritance

`resources/views/layouts/app.blade.php`:
```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'My Application')</title>
</head>
<body>
    <nav>...</nav>

    <main>
        @yield('content')
    </main>
</body>
</html>
```

`resources/views/taches/index.blade.php`:
```blade
@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
    <h1>My Tasks</h1>
    @foreach ($taches as $tache)
        <p>{{ $tache->titre }}</p>
    @endforeach
@endsection
```

> 💡 This is the same principle as `Vue::afficher()` with `header.php`/`footer.php` from [module 03.2](../../03-php-avance/02-architecture-mvc-from-scratch/README.en.md), but with dedicated syntax: `@extends` declares the parent layout, `@section`/`@endsection` fill in its zones (`@yield`).

### Blade components: factoring out reusable blocks

```bash
php artisan make:component Alert
```

`resources/views/components/alert.blade.php`:
```blade
<div class="alert alert-{{ $type }}">
    {{ $slot }}
</div>
```

Usage in any view:
```blade
<x-alert type="danger">
    An error occurred!
</x-alert>
```

### Useful directives

```blade
@csrf                          {{-- injects the CSRF token (module 02.6), automatic inside a <form> --}}
@method('PUT')                  {{-- simulates PUT/DELETE in an HTML form (which only supports GET/POST) --}}

@error('titre')
    <span class="error">{{ $message }}</span>
@enderror

{{-- Loop with iteration info --}}
@foreach ($taches as $tache)
    {{ $loop->index }}: {{ $tache->titre }}
    @if ($loop->last) (last task) @endif
@endforeach
```

> 📌 `@csrf` automates exactly the hidden token you hand-generated with `CsrfHelper::jeton()` in the [level 02 mini-project](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md).

## ✅ Key takeaways

- `{{ }}` escapes automatically (equivalent to `htmlspecialchars()`); `{!! !!}` doesn't escape, reserve it for trusted content.
- `@extends`/`@section`/`@yield` implement layout inheritance, replacing manual header/footer includes.
- Blade components (`<x-component-name>`) factor out reusable interface blocks.
- `@csrf` and `@method('PUT')` automate mechanics you've already hand-written in native PHP.

## ➡️ Going further

- [laravel.com/docs — Blade Templates](https://laravel.com/docs/blade)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [06.2 — Routing and Controllers](../02-routing-controllers/README.en.md) · **Next:** [06.4 — Eloquent ORM: The Basics](../04-eloquent-orm-bases/README.en.md)
