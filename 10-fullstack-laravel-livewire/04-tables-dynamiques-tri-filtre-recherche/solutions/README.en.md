# Solutions — 10.4 Dynamic Livewire Tables

## Exercise 1

```php
class ProduitsTable extends Component
{
    public string $recherche = '';

    public function render()
    {
        return view('livewire.produits-table', [
            'produits' => Produit::where('nom', 'like', "%{$this->recherche}%")->get(),
        ]);
    }
}
```
```blade
<input type="text" wire:model.live.debounce.300ms="recherche" placeholder="Search...">
```

## Exercise 2

```php
private const COLONNES_TRI_AUTORISEES = ['nom', 'prix'];
public string $tri = 'nom';
public string $ordre = 'asc';

public function trierPar(string $colonne): void
{
    if (!in_array($colonne, self::COLONNES_TRI_AUTORISEES, true)) return;
    if ($this->tri === $colonne) {
        $this->ordre = $this->ordre === 'asc' ? 'desc' : 'asc';
    } else {
        $this->tri = $colonne;
        $this->ordre = 'asc';
    }
}
```
```blade
<th wire:click="trierPar('prix')">Price {{ $tri === 'prix' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}</th>
```

## Exercise 3

```php
use Livewire\WithPagination;

class ProduitsTable extends Component
{
    use WithPagination;

    #[Url] public string $recherche = '';
    #[Url] public ?int $categorieId = null;

    public function render()
    {
        $produits = Produit::query()
            ->when($this->recherche !== '', fn ($q) => $q->where('nom', 'like', "%{$this->recherche}%"))
            ->when($this->categorieId !== null, fn ($q) => $q->where('categorie_id', $this->categorieId))
            ->paginate(10);

        return view('livewire.produits-table', compact('produits'));
    }
}
```

## Exercise 4

```php
public function updatingRecherche(): void { $this->resetPage(); }
public function updatingCategorieId(): void { $this->resetPage(); }
```
Without this hook: while on page 3, typing a search that only returns 1
page of results shows an EMPTY table (Livewire tries to display page 3
of a result that only has one) — a classic UX bug, fixed by
systematically going back to page 1 as soon as a filter changes.

## Exercise 5

With `#[Url]`, the URL looks like:
```
http://localhost:8000/produits?recherche=clavier&tri=prix&ordre=asc&page=2
```
Opened in a new tab, Livewire reads these parameters on first render
and initializes the component in the exact same state.

Benefit over a component with NO URL sync: the state would then only
live in the component's server-side session (or be lost on reload) —
impossible to share a "here are keyboards sorted by price" link with a
colleague, impossible to use the browser's Back button to return to a
previous filter, and refreshing the page (F5) would reset everything.
`#[Url]` restores the behavior expected of a real web page, even inside
a fully reactive interface.
