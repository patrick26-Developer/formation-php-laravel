# Solutions — 10.4 Tables dynamiques Livewire

## Exercice 1

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
<input type="text" wire:model.live.debounce.300ms="recherche" placeholder="Rechercher...">
```

## Exercice 2

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
<th wire:click="trierPar('prix')">Prix {{ $tri === 'prix' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}</th>
```

## Exercice 3

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

## Exercice 4

```php
public function updatingRecherche(): void { $this->resetPage(); }
public function updatingCategorieId(): void { $this->resetPage(); }
```
Sans ce hook : en étant sur la page 3, taper une recherche qui ne renvoie
que 1 page de résultats affiche une table VIDE (Livewire tente d'afficher
la page 3 d'un résultat qui n'en a qu'une) — un bug d'UX classique,
corrigé en ramenant systématiquement à la page 1 dès qu'un filtre change.

## Exercice 5

Avec `#[Url]`, l'URL ressemble à :
```
http://localhost:8000/produits?recherche=clavier&tri=prix&ordre=asc&page=2
```
Ouverte dans un nouvel onglet, Livewire lit ces paramètres au premier
rendu et initialise le composant dans le même état exact.

Avantage par rapport à un composant SANS synchronisation d'URL : l'état
serait alors stocké uniquement dans la session du composant côté serveur
(ou perdu au rechargement) — impossible de partager un lien "voici les
claviers triés par prix" à un collègue, impossible d'utiliser le bouton
Précédent du navigateur pour revenir à un filtre précédent, et un
rafraîchissement de page (F5) réinitialiserait tout. `#[Url]` restaure le
comportement attendu d'une vraie page web, même dans une interface
entièrement réactive.
