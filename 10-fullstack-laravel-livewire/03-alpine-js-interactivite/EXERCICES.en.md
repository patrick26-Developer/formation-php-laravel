# Exercises — 10.3 Alpine.js for Lightweight Interactivity

## Exercise 1 — Dropdown menu (easy)

Create a purely Alpine dropdown menu (`x-data`, `x-show`, `@click`), with no Livewire component at all.

## Exercise 2 — Tabs (easy)

Create an Alpine tab system (`x-data="{ onglet: 'infos' }"`, several buttons that change `onglet`, several `x-show="onglet === '...'"` blocks).

## Exercise 3 — Show/hide a password (medium)

Create a password field with an "eye" button toggling between `type="password"` and `type="text"` via Alpine (`x-data="{ visible: false }"`, `:type="visible ? 'text' : 'password'"`).

## Exercise 4 — Alpine + Livewire combined (medium)

Reuse the `Interrupteur` component from [module 10.1](../01-livewire-fondamentaux/README.en.md). Add an Alpine confirmation (`x-data`, a simple dialog box) before calling `wire:click="basculer"`, only when turning it off (not when turning it on).

## Exercise 5 — $wire for a hybrid counter (hard)

Create a Livewire component with a `total` property. From a separate Alpine block in the same view, display `$wire.total` in real time (`x-text="$wire.total"`) and add an Alpine button that calls `$wire.incrementer()`. Explain in a comment why this button still triggers a server request, unlike the previous exercises.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
