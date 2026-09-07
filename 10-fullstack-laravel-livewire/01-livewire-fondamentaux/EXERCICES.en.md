# Exercises — 10.1 Livewire: The Fundamentals

## Exercise 1 — First counter (easy)

Create the lesson's `Compteur` component. Add a "-1" button and a "Reset" button (sets `total` back to 0).

## Exercise 2 — Property initialized via mount() (easy)

Modify `Compteur` to accept an initial value via `mount(int $valeurInitiale = 0)`. Display two counters on the same page with different initial values (`<livewire:compteur :valeur-initiale="5" />` and `10`).

## Exercise 3 — Toggling a boolean state (medium)

Create an `Interrupteur` component with an `$actif` (bool) property and a `basculer()` method that flips it. Display "On"/"Off" based on the state, with a different visual style (background color).

## Exercise 4 — Several independent instances (medium)

Place three `<livewire:interrupteur />` on the same page. Verify clicking one doesn't affect the others — each instance has its own state on the server.

## Exercise 5 — Complete lifecycle (hard)

Add to `Compteur` a `mount()` method that logs (`logger()`) "Component mounted with value X", and an `updated($nom, $valeur)` method (an automatic Livewire hook, called after EVERY public property change) that logs each change. Observe the logs after several clicks and explain in a comment why `updated()` does NOT fire for the first value set by `mount()`.

---

See [solutions/README.md](solutions/README.md) for the answer key.
