# 10.4 — Dynamic Tables: Sort, Filter, Search in Livewire

> **Status:** ✅ Available

## 🎯 Objectives

- Build a data table with real-time search.
- Implement reactive sorting and filtering with no page reload.
- Paginate a Livewire component.
- Sync the component's state with the URL (bookmarking, browser back button).

## 📋 Prerequisites

All previous Level 10 modules, and [06.7 — Full Laravel CRUD](../../06-laravel-fondamentaux/07-crud-complet-laravel-tri-filtre-recherche/README.en.md)

## ⏱️ Estimated duration

3h.

## 📖 Theory

This module reproduces — as a **reactive interface, with no page reload** — exactly the sort/filter/search/pagination CRUD from module 06.7, already built three times in this training (native PHP in module 02.9, classic Laravel in module 06.7, an API in module 09).

### The complete table component

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

    #[Url] // syncs this property with the URL's query string
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

    // Resets pagination every time the search changes,
    // to avoid staying stuck on "page 5" of a filtered result
    // that now only has 2 pages.
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
    <input type="text" wire:model.live.debounce.300ms="recherche" placeholder="Search...">

    <select wire:model.live="categorieId">
        <option value="">All categories</option>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
        @endforeach
    </select>

    <table>
        <thead>
            <tr>
                <th wire:click="trierPar('titre')" style="cursor:pointer">
                    Title {{ $tri === 'titre' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}
                </th>
                <th wire:click="trierPar('prix')" style="cursor:pointer">
                    Price {{ $tri === 'prix' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}
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
                <tr><td colspan="2">No results.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $annonces->links() }}
</div>
```

### Key points of this implementation

**`wire:model.live.debounce.300ms`**: syncs the field on every keystroke, but **waits for 300ms of silence** before triggering the server request — avoids a request on every letter typed (a reminder of module 10.2's point about the cost of `.live`), while keeping reactivity that feels instant.

**`#[Url]`**: syncs a property with the URL's query string (`?recherche=velo&tri=prix&ordre=asc`). Without this attribute, the filter's state would be **lost** on page refresh or impossible to share via a link — exactly the problem `withQueryString()` solved in [module 06.7](../../06-laravel-fondamentaux/07-crud-complet-laravel-tri-filtre-recherche/README.en.md), automated here by Livewire.

**`wire:key`**: Livewire needs a unique, stable key per row to know which one changed between two renders (the same role as the `key` prop in React/Vue) — **essential** in any Blade loop inside a Livewire component, or you risk subtle display bugs when sorting/filtering.

**`updatingRecherche()`**: an automatic Livewire hook (`updating{PropertyName}`), called **right before** `$recherche` changes — the ideal place to reset pagination.

## ✅ Key takeaways

- `#[Url]` syncs a Livewire property with the URL, making a filter/sort state shareable and persistent across reloads.
- `.debounce.300ms` limits the network cost of a `wire:model.live` on a search field, without sacrificing perceived reactivity.
- `wire:key` is essential in any Livewire Blade loop, for correct element tracking between two renders.
- `updating{Property}()` is the right hook to reset pagination when a filter changes.

## ➡️ Going further

- [livewire.laravel.com/docs/pagination](https://livewire.laravel.com/docs/pagination)
- [livewire.laravel.com/docs/url](https://livewire.laravel.com/docs/url)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [10.3 — Alpine.js](../03-alpine-js-interactivite/README.en.md) · **Next:** [Mini-project: Livewire Admin Dashboard](../projet-mini-07-dashboard-admin-livewire/README.en.md)
