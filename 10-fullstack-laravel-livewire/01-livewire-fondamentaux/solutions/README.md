# Solutions — 10.1 Livewire : les fondamentaux

## Exercice 1

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
    <p>Total : {{ $total }}</p>
    <button wire:click="incrementer">+1</button>
    <button wire:click="decrementer">-1</button>
    <button wire:click="reinitialiser">Réinitialiser</button>
</div>
```

## Exercice 2

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

## Exercice 3

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
    <p>{{ $actif ? 'Allumé' : 'Éteint' }}</p>
    <button wire:click="basculer">Basculer</button>
</div>
```

## Exercice 4

```blade
<livewire:interrupteur />
<livewire:interrupteur />
<livewire:interrupteur />
```
Chaque `<livewire:interrupteur />` génère une instance de composant avec
un identifiant unique côté serveur : cliquer sur l'un déclenche une
requête AJAX qui ne concerne QUE cette instance précise, les deux autres
restent inchangées.

## Exercice 5

```php
public function mount(int $valeurInitiale = 0): void
{
    $this->total = $valeurInitiale;
    logger("Composant monté avec la valeur $valeurInitiale");
}

public function updated($nom, $valeur): void
{
    logger("Propriété '$nom' mise à jour : $valeur");
}
```
`updated()` ne se déclenche pas pour la valeur initiale car ce hook
réagit spécifiquement aux changements provoqués par une interaction
CLIENT (`wire:model`, ou toute méthode appelée via `wire:click` qui
modifie une propriété) — `mount()` s'exécute une seule fois, au moment
de la création du composant, avant même que le "cycle réactif" ne
commence à surveiller les changements ultérieurs.
