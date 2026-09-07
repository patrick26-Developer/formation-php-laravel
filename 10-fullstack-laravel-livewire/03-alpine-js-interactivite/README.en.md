# 10.3 — Alpine.js for Lightweight Interactivity

> **Status:** ✅ Available

## 🎯 Objectives

- Understand when to use Alpine.js instead of Livewire.
- Use `x-data`, `x-show`, `x-on` for purely client-side interactivity.
- Combine Alpine.js and Livewire within the same component.

## 📋 Prerequisites

[10.2 — Reactive Components and Forms](../02-composants-reactifs-formulaires/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### Why Alpine.js alongside Livewire?

Every Livewire interaction triggers a network request to the server (module 10.1). For **purely visual** interactions, with no need for server data (opening/closing a dropdown menu, showing/hiding a password, an active tab) — making a network round trip would be unnecessary waste. **Alpine.js** handles these interactions **entirely in the browser**, in minimal JavaScript, directly within HTML attributes.

> 💡 Alpine.js is **automatically included** with Livewire (since Livewire 3): no separate installation is needed in a project that already uses Livewire.

### `x-data` and `x-show`: state purely local to the browser

```blade
<div x-data="{ ouvert: false }">
    <button x-on:click="ouvert = !ouvert">Show details</button>

    <div x-show="ouvert">
        Content shown/hidden instantly, with no server request.
    </div>
</div>
```

> 📌 `x-data="{ ouvert: false }"` declares a JavaScript variable local to this HTML block. `x-on:click` (shorthand `@click`) reacts to a DOM event. None of these interactions ever reach the Laravel server.

### `x-model`: binding a field to an Alpine variable (comparison with Livewire)

```blade
<div x-data="{ recherche: '' }">
    <input type="text" x-model="recherche">
    <p x-show="recherche.length > 0">You're searching for: <span x-text="recherche"></span></p>
</div>
```

> ⚠️ This Alpine code stays **entirely client-side**: it cannot query the database. For a real search filtering server results, you need Livewire (`wire:model`, module 10.4) or JavaScript calling an API (level 09) — Alpine alone only suffices for pure UI state.

### Combining Alpine.js and Livewire in the same component

```blade
<div x-data="{ menuOuvert: false }">
    <button @click="menuOuvert = !menuOuvert">Actions</button>

    <div x-show="menuOuvert">
        {{-- This button, on the other hand, does trigger a server request --}}
        <button wire:click="archiverAnnonce">Archive</button>
    </div>
</div>
```

> 💡 This mix is very common in practice: Alpine handles "is the menu visually open?" (never needs the server to know), Livewire handles "what happens when Archive is clicked?" (needs the server, since it changes data in the database).

### `$wire`: accessing Livewire from Alpine

```blade
<div x-data>
    <button @click="$wire.incrementer()">Increment via Alpine</button>
    <span x-text="$wire.total"></span>
</div>
```

> 📌 `$wire` exposes the parent Livewire component's properties and methods directly to Alpine — useful for fine-grained hybrid interactions (for example, a JavaScript confirmation before calling a Livewire method).

## ✅ Key takeaways

- Alpine.js handles purely visual interactivity (menus, tabs, conditional display) without ever hitting the server.
- Alpine is automatically included with Livewire 3, with no separate installation.
- `x-data`/`x-show`/`x-on`/`x-model` stay entirely client-side: no direct database access.
- `$wire` lets Alpine call methods or read properties of the parent Livewire component.

## ➡️ Going further

- [alpinejs.dev](https://alpinejs.dev/)
- [livewire.laravel.com/docs/alpine](https://livewire.laravel.com/docs/alpine)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [10.2 — Reactive Components and Forms](../02-composants-reactifs-formulaires/README.en.md) · **Next:** [10.4 — Dynamic Tables: Sort, Filter, Search](../04-tables-dynamiques-tri-filtre-recherche/README.en.md)
