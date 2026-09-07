# 10.4 — Tables dynamiques : tri, filtre, recherche en Livewire

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Construire une table de données avec recherche en temps réel.
- Implémenter tri et filtre réactifs sans rechargement de page.
- Paginer un composant Livewire.
- Synchroniser l'état du composant avec l'URL (bookmark, bouton retour navigateur).

## 📋 Prérequis

Tous les modules précédents du Niveau 10, et [06.7 — CRUD complet Laravel](../../06-laravel-fondamentaux/07-crud-complet-laravel-tri-filtre-recherche/README.md)

## ⏱️ Durée estimée

3h.

## 📖 Théorie

Ce module reproduit — en **interface réactive, sans rechargement de page** — exactement le CRUD tri/filtre/recherche/pagination du module 06.7, déjà construit trois fois dans cette formation (PHP natif au module 02.9, Laravel classique au module 06.7, API au module 09).

### Le composant de table complet

```php
// app/Livewire/AnnoncesTable.php
namespace App\Livewire;

use App\Models\Annonce;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class AnnoncesTable extends Component
{
    use WithPagination;

    #[Url] // synchronise cette propriété avec la query string de l'URL
    public string $recherche = '';

    #[Url]
    public ?int $categorieId = null;

    #[Url]
    public string $tri = 'created_at';

    #[Url]
    public string $ordre = 'desc';

    private const COLONNES_TRI_AUTORISEES = ['prix', 'titre', 'created_at'];

    public function trierPar(string $colonne): void
    {
        if (!in_array($colonne, self::COLONNES_TRI_AUTORISEES, true)) {
            return;
        }

        if ($this->tri === $colonne) {
            $this->ordre = $this->ordre === 'asc' ? 'desc' : 'asc';
        } else {
            $this->tri = $colonne;
            $this->ordre = 'asc';
        }
    }

    // Réinitialise la pagination à chaque fois que la recherche change,
    // pour éviter de rester bloqué sur "page 5" d'un résultat filtré
    // qui n'a plus que 2 pages.
    public function updatingRecherche(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $annonces = Annonce::query()
            ->with('categorie')
            ->actives()
            ->when($this->recherche !== '', fn ($q) => $q->where('titre', 'like', "%{$this->recherche}%"))
            ->when($this->categorieId !== null, fn ($q) => $q->deLaCategorie($this->categorieId))
            ->orderBy($this->tri, $this->ordre)
            ->paginate(10);

        return view('livewire.annonces-table', ['annonces' => $annonces]);
    }
}
```

```blade
{{-- resources/views/livewire/annonces-table.blade.php --}}
<div>
    <input type="text" wire:model.live.debounce.300ms="recherche" placeholder="Rechercher...">

    <select wire:model.live="categorieId">
        <option value="">Toutes les catégories</option>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
        @endforeach
    </select>

    <table>
        <thead>
            <tr>
                <th wire:click="trierPar('titre')" style="cursor:pointer">
                    Titre {{ $tri === 'titre' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}
                </th>
                <th wire:click="trierPar('prix')" style="cursor:pointer">
                    Prix {{ $tri === 'prix' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($annonces as $annonce)
                <tr wire:key="annonce-{{ $annonce->id }}">
                    <td>{{ $annonce->titre }}</td>
                    <td>{{ number_format($annonce->prix, 2) }} €</td>
                </tr>
            @empty
                <tr><td colspan="2">Aucun résultat.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $annonces->links() }}
</div>
```

### Points clés de cette implémentation

**`wire:model.live.debounce.300ms`** : synchronise le champ à chaque frappe, mais **attend 300ms de silence** avant de déclencher la requête serveur — évite une requête à chaque lettre tapée (rappel du module 10.2 sur le coût de `.live`), tout en gardant une réactivité perçue comme instantanée.

**`#[Url]`** : synchronise une propriété avec la query string de l'URL (`?recherche=velo&tri=prix&ordre=asc`). Sans cet attribut, l'état du filtre serait **perdu** au rafraîchissement de la page ou impossible à partager via un lien — exactement le problème que `withQueryString()` résolvait au [module 06.7](../../06-laravel-fondamentaux/07-crud-complet-laravel-tri-filtre-recherche/README.md), ici automatisé par Livewire.

**`wire:key`** : Livewire a besoin d'une clé unique et stable par ligne pour savoir laquelle a changé entre deux rendus (le même rôle que la prop `key` en React/Vue) — **indispensable** dans toute boucle Blade à l'intérieur d'un composant Livewire, sous peine de bugs d'affichage subtils lors du tri/filtre.

**`updatingRecherche()`** : un hook automatique Livewire (`updating{NomPropriete}`), appelé **juste avant** que `$recherche` ne change — l'endroit idéal pour réinitialiser la pagination.

## ✅ Points clés à retenir

- `#[Url]` synchronise une propriété Livewire avec l'URL, rendant un état de filtre/tri partageable et persistant au rechargement.
- `.debounce.300ms` limite le coût réseau d'un `wire:model.live` sur un champ de recherche, sans sacrifier la réactivité perçue.
- `wire:key` est indispensable dans toute boucle Blade Livewire, pour un suivi correct des éléments entre deux rendus.
- `updating{Propriete}()` est le hook approprié pour réinitialiser la pagination quand un filtre change.

## ➡️ Pour aller plus loin

- [livewire.laravel.com/docs/pagination](https://livewire.laravel.com/docs/pagination)
- [livewire.laravel.com/docs/url](https://livewire.laravel.com/docs/url)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [10.3 — Alpine.js](../03-alpine-js-interactivite/README.md) · **Suite :** [Mini-projet : Dashboard admin Livewire](../projet-mini-07-dashboard-admin-livewire/README.md)
