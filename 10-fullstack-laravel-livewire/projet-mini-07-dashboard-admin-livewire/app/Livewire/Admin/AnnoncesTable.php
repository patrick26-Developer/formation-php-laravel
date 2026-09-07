<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Annonce;
use App\Models\Category;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class AnnoncesTable extends Component
{
    use WithPagination;

    private const COLONNES_TRI_AUTORISEES = ['titre', 'prix', 'created_at'];

    #[Url]
    public string $recherche = '';

    #[Url]
    public ?int $categorieId = null;

    #[Url]
    public string $statut = 'toutes'; // toutes | actives | inactives

    #[Url]
    public string $tri = 'created_at';

    #[Url]
    public string $ordre = 'desc';

    public function updatingRecherche(): void
    {
        $this->resetPage();
    }

    public function updatingCategorieId(): void
    {
        $this->resetPage();
    }

    public function updatingStatut(): void
    {
        $this->resetPage();
    }

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

    /**
     * Bascule le statut actif/inactif d'une annonce (modération), puis
     * notifie le widget de statistiques (module 10.2 : communication
     * entre composants) pour qu'il se recalcule sans rechargement de page.
     */
    public function basculerStatut(int $annonceId): void
    {
        $annonce = Annonce::findOrFail($annonceId);
        $annonce->update(['active' => !$annonce->active]);

        $this->dispatch('statistiques-modifiees');
    }

    public function supprimer(int $annonceId): void
    {
        Annonce::findOrFail($annonceId)->delete();

        $this->dispatch('statistiques-modifiees');
    }

    #[On('categorie-creee')]
    public function rafraichirCategories(): void
    {
        // Existe pour être notifié si une catégorie est ajoutée ailleurs
        // dans le dashboard ; render() recharge de toute façon $categories.
    }

    public function render()
    {
        $annonces = Annonce::query()
            ->with(['categorie', 'user'])
            ->when($this->recherche !== '', fn ($q) => $q->where('titre', 'like', "%{$this->recherche}%"))
            ->when($this->categorieId !== null, fn ($q) => $q->deLaCategorie($this->categorieId))
            ->when($this->statut === 'actives', fn ($q) => $q->where('active', true))
            ->when($this->statut === 'inactives', fn ($q) => $q->where('active', false))
            ->orderBy($this->tri, $this->ordre)
            ->paginate(10);

        return view('livewire.admin.annonces-table', [
            'annonces' => $annonces,
            'categories' => Category::orderBy('nom')->get(),
        ]);
    }
}
