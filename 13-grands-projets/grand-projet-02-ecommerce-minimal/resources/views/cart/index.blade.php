<x-app-layout>
    <div class="p-6">
        <h1>Votre panier</h1>

        @if (session('erreur')) <p style="color:red">{{ session('erreur') }}</p> @endif

        @forelse ($lignes as $ligne)
            <div style="display:flex; justify-content:space-between; border-bottom:1px solid #eee; padding:0.5rem 0;">
                <span>{{ $ligne['produit']->nom }} × {{ $ligne['quantite'] }}</span>
                <span>{{ number_format($ligne['produit']->prix * $ligne['quantite'], 2) }} €</span>
                <form method="POST" action="{{ route('cart.retirer', $ligne['produit']) }}">
                    @csrf @method('DELETE')
                    <button type="submit">Retirer</button>
                </form>
            </div>
        @empty
            <p>Votre panier est vide.</p>
        @endforelse

        @if ($lignes !== [])
            <h2>Total : {{ number_format($total, 2) }} €</h2>

            @auth
                <form method="POST" action="{{ route('orders.valider') }}">
                    @csrf
                    <button type="submit">Valider la commande (paiement simulé)</button>
                </form>
            @else
                <p><a href="{{ route('login') }}">Connectez-vous</a> pour valider votre commande.</p>
            @endauth
        @endif
    </div>
</x-app-layout>
