# Solutions — 10.2 Composants réactifs et formulaires

## Exercice 1

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
    <button type="submit">Créer</button>
</form>
```

## Exercice 2

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

## Exercice 3

```php
public function updated($property): void
{
    $this->validateOnly($property);
}
```
```blade
<input type="text" wire:model.live="nom">
```
En tapant une seule lettre puis en l'effaçant, l'erreur "au moins 2
caractères" apparaît et disparaît en direct, sans jamais cliquer sur le
bouton "Créer".

## Exercice 4

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

## Exercice 5

```blade
{{-- Version déferred --}}
<input type="text" wire:model="recherche">
<button wire:click="rechercher">Rechercher</button>

{{-- Version live --}}
<input type="text" wire:model.live="recherche">
```
Pour taper "laravel" (7 caractères) :
- Version déferred : **1 requête AJAX** au clic sur "Rechercher".
- Version live : **jusqu'à 7 requêtes AJAX**, une par frappe (Livewire
  applique un léger "debounce" par défaut, réduisant parfois ce nombre,
  mais restant nettement supérieur à 1).

Compromis : `.live` offre une réactivité immédiate (résultats visibles
sans action supplémentaire) au prix d'un coût réseau et serveur bien plus
élevé. Pour une recherche, ce compromis est souvent acceptable (module
10.4) ; pour un formulaire de 10 champs, appliquer `.live` partout
multiplierait inutilement les requêtes pour un gain d'expérience marginal.
