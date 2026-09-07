<x-app-layout>
    <div class="p-6">
        <h1>Mes commandes</h1>

        @forelse ($commandes as $commande)
            <div style="border:1px solid #ccc; padding:1rem; margin-bottom:0.5rem;">
                <p>Commande #{{ $commande->id }} — {{ $commande->statut }} — {{ number_format($commande->total, 2) }} €</p>
                <p><small>{{ $commande->created_at->format('d/m/Y H:i') }}</small></p>
            </div>
        @empty
            <p>Aucune commande pour le moment.</p>
        @endforelse

        {{ $commandes->links() }}
    </div>
</x-app-layout>
