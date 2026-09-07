<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Annonce;
use Livewire\Attributes\On;
use Livewire\Component;

class StatistiquesWidget extends Component
{
    /**
     * Écoute l'événement émis par AnnoncesTable (module 10.2) : ce widget
     * n'a AUCUNE connaissance directe de la table, il réagit simplement
     * à un événement nommé, quel que soit son émetteur.
     */
    #[On('statistiques-modifiees')]
    public function recalculer(): void
    {
        // La simple présence de cette méthode écoutant l'événement suffit
        // à déclencher un nouveau render() avec des données fraîches.
    }

    public function render()
    {
        return view('livewire.admin.statistiques-widget', [
            'total' => Annonce::count(),
            'actives' => Annonce::where('active', true)->count(),
            'inactives' => Annonce::where('active', false)->count(),
        ]);
    }
}
