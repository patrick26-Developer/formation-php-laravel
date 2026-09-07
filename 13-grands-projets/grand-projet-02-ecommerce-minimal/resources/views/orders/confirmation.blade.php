<x-app-layout>
    <div class="p-6">
        <h1>Commande #{{ $order->id }} confirmée</h1>
        <p>Statut : {{ $order->statut }}</p>
        <p>Total : {{ number_format($order->total, 2) }} €</p>

        <ul>
            @foreach ($order->items as $item)
                <li>{{ $item->nom_produit }} × {{ $item->quantite }} — {{ number_format($item->sousTotal(), 2) }} €</li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
