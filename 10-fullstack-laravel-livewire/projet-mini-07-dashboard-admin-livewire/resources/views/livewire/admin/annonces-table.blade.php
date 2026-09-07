<div>
    <div style="display:flex; gap:0.5rem; margin-bottom:1rem;">
        <input type="text" wire:model.live.debounce.300ms="recherche" placeholder="Rechercher un titre...">

        <select wire:model.live="categorieId">
            <option value="">Toutes les catégories</option>
            @foreach ($categories as $categorie)
                <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option>
            @endforeach
        </select>

        <select wire:model.live="statut">
            <option value="toutes">Tous les statuts</option>
            <option value="actives">Actives</option>
            <option value="inactives">Inactives</option>
        </select>
    </div>

    <table border="1" cellpadding="6" style="width:100%;">
        <thead>
            <tr>
                <th wire:click="trierPar('titre')" style="cursor:pointer;">
                    Titre {{ $tri === 'titre' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}
                </th>
                <th wire:click="trierPar('prix')" style="cursor:pointer;">
                    Prix {{ $tri === 'prix' ? ($ordre === 'asc' ? '↑' : '↓') : '' }}
                </th>
                <th>Catégorie</th>
                <th>Vendeur</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($annonces as $annonce)
                <tr wire:key="annonce-{{ $annonce->id }}">
                    <td>{{ $annonce->titre }}</td>
                    <td>{{ number_format($annonce->prix, 2) }} €</td>
                    <td>{{ $annonce->categorie->nom }}</td>
                    <td>{{ $annonce->user->name }}</td>
                    <td>{{ $annonce->active ? '✅ Active' : '⛔ Inactive' }}</td>
                    <td>
                        <button wire:click="basculerStatut({{ $annonce->id }})">
                            {{ $annonce->active ? 'Désactiver' : 'Activer' }}
                        </button>

                        {{-- Alpine (module 10.3) gère la confirmation, purement côté client,
                             AVANT de déclencher l'appel serveur Livewire. --}}
                        <button
                            x-data
                            x-on:click="if (confirm('Supprimer définitivement cette annonce ?')) $wire.supprimer({{ $annonce->id }})"
                        >
                            Supprimer
                        </button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6">Aucune annonce ne correspond à ces filtres.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div wire:loading class="text-sm text-gray-500">Chargement...</div>

    {{ $annonces->links() }}
</div>
