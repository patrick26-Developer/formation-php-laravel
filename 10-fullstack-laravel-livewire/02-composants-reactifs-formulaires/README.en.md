# 10.2 — Reactive Components and Forms

> **Status:** ✅ Available

## 🎯 Objectives

- Bind a form field to a property with `wire:model`.
- Validate a Livewire form in real time.
- Emit and listen for events between components.
- Understand `wire:model.live` vs `wire:model` (deferred).

## 📋 Prerequisites

[10.1 — Livewire: The Fundamentals](../01-livewire-fondamentaux/README.en.md), [06.6 — Form Validation](../../06-laravel-fondamentaux/06-validation-formulaires/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### `wire:model`: binding a field to a property

```php
class FormulaireTache extends Component
{
    public string $titre = '';
    public string $description = '';

    public function creer(): void
    {
        Tache::create(['titre' => $this->titre, 'description' => $this->description]);
        $this->reset(['titre', 'description']); // clears the form after creation
    }

    public function render() { return view('livewire.formulaire-tache'); }
}
```

```blade
<form wire:submit="creer">
    <input type="text" wire:model="titre">
    <textarea wire:model="description"></textarea>
    <button type="submit">Create</button>
</form>
```

> 💡 `wire:model="titre"` automatically syncs the field's value with `$this->titre` on the server — the equivalent of reading `$_POST['titre']` (module 01.7), but updated continuously rather than only at submission time.

### `wire:model` (deferred) vs `wire:model.live`

| | `wire:model` | `wire:model.live` |
|---|---|---|
| When syncing happens | On the next network event (e.g., form submission) | On **every keystroke**, immediately |
| Network cost | Low (a single request on submit) | High (one request per keystroke) |
| Use case | Most classic forms | Real-time search (module 10.4), instant preview |

> ⚠️ Using `.live` by default on every field is a performance anti-pattern: every keystroke triggers a full AJAX request (module 08.2: measure before optimizing applies to Livewire usage too). Reserve `.live` for fields that **genuinely** need an immediate reaction.

### Real-time validation

```php
use Livewire\Attributes\Rule;

class FormulaireTache extends Component
{
    #[Rule('required|min:3|max:150')]
    public string $titre = '';

    public function creer(): void
    {
        $this->validate(); // applies the rules declared with #[Rule]

        Tache::create(['titre' => $this->titre]);
        $this->reset('titre');
    }
}
```

```blade
<input type="text" wire:model="titre">
@error('titre') <span class="text-red-500">{{ $message }}</span> @enderror
```

> 📌 Exactly the same validation rules as Form Requests (module 06.6) — Livewire reuses the **same** underlying Laravel validator, only the way it's triggered changes (`$this->validate()` in a method, rather than automatic across the whole HTTP request).

### Real-time validation, on every change

```php
public function updated($property): void
{
    $this->validateOnly($property); // validates ONLY the field that just changed
}
```

```blade
<input type="text" wire:model.live="titre">
```

> 💡 Combined with `wire:model.live`, this shows a validation error **as the user types**, without waiting for submission — a user experience close to a modern SPA, entirely in PHP.

### Communication between components: events

```php
// Component A: emits an event after creation
class FormulaireTache extends Component
{
    public function creer(): void
    {
        $this->validate();
        Tache::create(['titre' => $this->titre]);
        $this->dispatch('tache-creee'); // emits a named event
        $this->reset('titre');
    }
}
```

```php
// Component B: listens for the event and refreshes
class ListeTaches extends Component
{
    #[\Livewire\Attributes\On('tache-creee')]
    public function rafraichir(): void
    {
        // The mere existence of this method, listening for the event,
        // is enough to trigger a new render() of this component.
    }

    public function render()
    {
        return view('livewire.liste-taches', ['taches' => Tache::latest()->get()]);
    }
}
```

> 📌 This is the **Observer** pattern (module 03.1) once again, this time applied to communication **between UI components** rather than between business classes — a "Form" component never needs to directly know about the "List" component to notify it of a change.

## ✅ Key takeaways

- `wire:model` syncs a field with a property; `.live` syncs it on every keystroke (expensive, reserve it for cases that truly need it).
- `#[Rule(...)]` + `$this->validate()` reuse the same validator as Form Requests.
- `validateOnly()` validates a single field, useful for targeted real-time validation.
- `dispatch()`/`#[On(...)]` let components communicate without knowing each other directly.

## ➡️ Going further

- [livewire.laravel.com/docs/forms](https://livewire.laravel.com/docs/forms)
- [livewire.laravel.com/docs/events](https://livewire.laravel.com/docs/events)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [10.1 — Livewire: The Fundamentals](../01-livewire-fondamentaux/README.en.md) · **Next:** [10.3 — Alpine.js for Lightweight Interactivity](../03-alpine-js-interactivite/README.md) *(French only)*
