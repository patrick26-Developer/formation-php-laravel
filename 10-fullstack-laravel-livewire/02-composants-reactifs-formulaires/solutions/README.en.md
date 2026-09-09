# Solutions — 10.2 Reactive Components and Forms

## Exercise 1

```php
class FormulaireCategorie extends Component
{
    public string $nom = '';

    public function creer(): void
    {
        Category::create(['nom' => $this->nom, 'slug' => \Str::slug($this->nom)]);
        $this->reset('nom');
    }

    public function render() { return view('livewire.formulaire-categorie'); }
}
```
```blade
<form wire:submit="creer">
    <input type="text" wire:model="nom">
    <button type="submit">Create</button>
</form>
```

## Exercise 2

```php
#[\Livewire\Attributes\Rule('required|min:2|max:50')]
public string $nom = '';

public function creer(): void
{
    $this->validate();
    Category::create(['nom' => $this->nom, 'slug' => \Str::slug($this->nom)]);
    $this->reset('nom');
}
```
```blade
<input type="text" wire:model="nom">
@error('nom') <span>{{ $message }}</span> @enderror
```

## Exercise 3

```php
public function updated($property): void
{
    $this->validateOnly($property);
}
```
```blade
<input type="text" wire:model.live="nom">
```
Typing a single letter then deleting it makes the "at least 2
characters" error appear and disappear live, without ever clicking the
"Create" button.

## Exercise 4

```php
// FormulaireCategorie
public function creer(): void
{
    $this->validate();
    Category::create(['nom' => $this->nom]);
    $this->dispatch('categorie-creee');
    $this->reset('nom');
}
```
```php
class ListeCategories extends Component
{
    #[\Livewire\Attributes\On('categorie-creee')]
    public function rafraichir(): void {}

    public function render()
    {
        return view('livewire.liste-categories', ['categories' => Category::latest()->get()]);
    }
}
```
```blade
<livewire:formulaire-categorie />
<livewire:liste-categories />
```

## Exercise 5

```blade
{{-- Deferred version --}}
<input type="text" wire:model="recherche">
<button wire:click="rechercher">Search</button>

{{-- Live version --}}
<input type="text" wire:model.live="recherche">
```
To type "laravel" (7 characters):
- Deferred version: **1 AJAX request** when clicking "Search".
- Live version: **up to 7 AJAX requests**, one per keystroke (Livewire
  applies a light default "debounce", sometimes reducing this count,
  but still well above 1).

Trade-off: `.live` offers immediate reactivity (results visible with
no extra action) at the cost of much higher network and server load.
For a search box, this trade-off is often acceptable (module 10.4); for
a 10-field form, applying `.live` everywhere would needlessly multiply
requests for a marginal experience gain.
