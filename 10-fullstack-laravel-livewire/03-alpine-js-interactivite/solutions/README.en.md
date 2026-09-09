# Solutions — 10.3 Alpine.js for Lightweight Interactivity

## Exercise 1

```blade
<div x-data="{ ouvert: false }" class="relative">
    <button @click="ouvert = !ouvert">Menu</button>
    <div x-show="ouvert" @click.outside="ouvert = false">
        <a href="#">Option 1</a>
        <a href="#">Option 2</a>
    </div>
</div>
```

## Exercise 2

```blade
<div x-data="{ onglet: 'infos' }">
    <button @click="onglet = 'infos'">Info</button>
    <button @click="onglet = 'avis'">Reviews</button>

    <div x-show="onglet === 'infos'">Info content.</div>
    <div x-show="onglet === 'avis'">Reviews content.</div>
</div>
```

## Exercise 3

```blade
<div x-data="{ visible: false }">
    <input :type="visible ? 'text' : 'password'" name="mot_de_passe">
    <button type="button" @click="visible = !visible">
        <span x-text="visible ? 'Hide' : 'Show'"></span>
    </button>
</div>
```

## Exercise 4

```blade
<div x-data="{ confirmerExtinction() { return this.actif ? confirm('Really turn off?') : true; } }">
    <button
        wire:click="basculer"
        @click="if ($wire.actif && !confirm('Really turn off?')) $event.stopImmediatePropagation()"
    >
        Toggle
    </button>
</div>
```
*(Simplified pattern: in a real project, you'd rather use
`wire:confirm="Really turn off?"`, a Livewire directive built exactly
for this purpose.)*

## Exercise 5

```blade
<div x-data>
    <p>Real-time value: <span x-text="$wire.total"></span></p>
    <button @click="$wire.incrementer()">Increment</button>
</div>
```
This button does trigger a server request because `$wire.incrementer()`
calls a PHP METHOD of the Livewire component (defined server-side) —
unlike exercises 1 to 3, where `ouvert`, `onglet`, `visible` are PURE
JavaScript variables, existing only in the browser with no
server-side counterpart to query.
