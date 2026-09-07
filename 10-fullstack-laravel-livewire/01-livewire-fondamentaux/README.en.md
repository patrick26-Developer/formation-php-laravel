# 10.1 — Livewire: The Fundamentals

> **Status:** ✅ Available

## 🎯 Objectives

- Understand how Livewire works.
- Create a first Livewire component with reactive state.
- Understand a component's request/response cycle.
- Choose between Livewire and a separate API depending on the need.

## 📋 Prerequisites

[Level 09 — REST API with Laravel](../../09-api-rest-laravel/README.en.md), [06.3 — Blade](../../06-laravel-fondamentaux/03-blade-templates/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### The problem Livewire solves

In level 09, building a reactive interface (instant search, a counter that updates without reloading the page) would have required a JSON API **and** client-side JavaScript to call it. **Livewire** achieves the same result by writing **only PHP and Blade**: every interaction automatically triggers an AJAX request, entirely handled by the framework, which re-executes the component on the server and returns only the HTML that changed.

### Installing Livewire

```bash
composer require livewire/livewire
```

### Creating a first component

```bash
php artisan make:livewire Compteur
```

```php
// app/Livewire/Compteur.php
namespace App\Livewire;

use Livewire\Component;

class Compteur extends Component
{
    public int $total = 0; // a PUBLIC PROPERTY = reactive state

    public function incrementer(): void
    {
        $this->total++;
    }

    public function render()
    {
        return view('livewire.compteur');
    }
}
```

```blade
{{-- resources/views/livewire/compteur.blade.php --}}
<div>
    <p>Total: {{ $total }}</p>
    <button wire:click="incrementer">+1</button>
</div>
```

```blade
{{-- On any page --}}
<livewire:compteur />
```

> 💡 `wire:click="incrementer"` triggers, on click, an **automatic** AJAX request to the server, which runs `incrementer()`, re-runs `render()`, and returns only the changed HTML — without a single line of JavaScript written. Compare with [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.en.md): this same need ("update a value without reloading the whole page") would have required a full form with a page reload in plain PHP.

### A component's lifecycle

1. **Initial mount**: `mount()` (optional, the equivalent of a constructor) initializes the properties.
2. **Initial render**: `render()` displays the component within the regular HTML page (first load).
3. **Interactions**: every `wire:click`, `wire:model`, etc. triggers an AJAX request that re-executes the whole component on the server and remembers the public properties' state between each request.

```php
class Compteur extends Component
{
    public int $total;

    public function mount(int $valeurInitiale = 0): void
    {
        $this->total = $valeurInitiale;
    }
}
```

```blade
<livewire:compteur :valeur-initiale="10" />
```

### Public properties: state's memory between requests

> ⚠️ A public Livewire property is **serialized and sent** to the client on every render, then **sent back to the server** on every subsequent interaction. Never store sensitive data (password, token) in a public property: it's visible in the HTML/network payload, exactly like a hidden form field.

### When to choose Livewire over an API + JavaScript (level 09)?

| | Livewire | Separate API + JS Frontend (Vue/React) |
|---|---|---|
| Languages to master | PHP + Blade only | PHP (API) + JavaScript (frontend) |
| Use case | Back-offices, complex forms, admin interfaces, MVPs | Native mobile apps, complex SPAs, separate frontend teams |
| Learning curve | Low for a developer already comfortable with Laravel | Requires distinct JS/frontend expertise |

> 📌 For this training and most internal/back-office projects, **Livewire is the recommended choice**: it avoids maintaining two codebases (backend + frontend), and a separate team isn't needed. A REST API (level 09) remains essential if a **native mobile** app needs to consume the same data.

## ✅ Key takeaways

- A Livewire component is a PHP class with reactive public properties and an associated Blade view.
- `wire:click` (and other `wire:*` directives) trigger automatic AJAX requests, with no JavaScript to write.
- A public property is visible client-side: never store sensitive data in one.
- Livewire suits back-offices and internal interfaces; a separate API remains necessary for native mobile.

## ➡️ Going further

- [livewire.laravel.com/docs](https://livewire.laravel.com/docs)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [Level 09 — REST API with Laravel](../../09-api-rest-laravel/README.en.md) · **Next:** [10.2 — Reactive Components and Forms](../02-composants-reactifs-formulaires/README.en.md)
