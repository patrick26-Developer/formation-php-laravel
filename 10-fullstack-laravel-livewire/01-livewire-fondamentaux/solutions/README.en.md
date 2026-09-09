# Solutions — 10.1 Livewire: The Fundamentals

## Exercise 1

```php
class Compteur extends Component
{
    public int $total = 0;

    public function incrementer(): void { $this->total++; }
    public function decrementer(): void { $this->total--; }
    public function reinitialiser(): void { $this->total = 0; }

    public function render() { return view('livewire.compteur'); }
}
```
```blade
<div>
    <p>Total: {{ $total }}</p>
    <button wire:click="incrementer">+1</button>
    <button wire:click="decrementer">-1</button>
    <button wire:click="reinitialiser">Reset</button>
</div>
```

## Exercise 2

```php
public function mount(int $valeurInitiale = 0): void
{
    $this->total = $valeurInitiale;
}
```
```blade
<livewire:compteur :valeur-initiale="5" />
<livewire:compteur :valeur-initiale="10" />
```

## Exercise 3

```php
class Interrupteur extends Component
{
    public bool $actif = false;

    public function basculer(): void { $this->actif = !$this->actif; }

    public function render() { return view('livewire.interrupteur'); }
}
```
```blade
<div style="background: {{ $actif ? 'lightgreen' : 'lightgray' }}; padding: 1rem;">
    <p>{{ $actif ? 'On' : 'Off' }}</p>
    <button wire:click="basculer">Toggle</button>
</div>
```

## Exercise 4

```blade
<livewire:interrupteur />
<livewire:interrupteur />
<livewire:interrupteur />
```
Each `<livewire:interrupteur />` generates a component instance with a
unique server-side identifier: clicking one triggers an AJAX request
that concerns ONLY that specific instance, the other two stay unchanged.

## Exercise 5

```php
public function mount(int $valeurInitiale = 0): void
{
    $this->total = $valeurInitiale;
    logger("Component mounted with value $valeurInitiale");
}

public function updated($nom, $valeur): void
{
    logger("Property '$nom' updated: $valeur");
}
```
`updated()` doesn't fire for the initial value because this hook
specifically reacts to changes caused by a CLIENT interaction
(`wire:model`, or any method called via `wire:click` that changes a
property) — `mount()` runs only once, when the component is created,
before the "reactive cycle" even starts watching for later changes.
