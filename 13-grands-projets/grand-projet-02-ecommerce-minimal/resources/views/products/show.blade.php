<x-app-layout>
    <div class="p-6">
        <p><a href="{{ route('products.index') }}">← Retour au catalogue</a></p>

        <h1>{{ $product->nom }}</h1>
        <p>{{ number_format($product->prix, 2) }} € — {{ $product->category->nom }}</p>
        <p>{{ $product->description }}</p>
        <p>Stock disponible : {{ $product->stock }}</p>

        @if ($product->estEnStock())
            <form method="POST" action="{{ route('cart.ajouter', $product) }}">
                @csrf
                <input type="number" name="quantite" value="1" min="1" max="{{ $product->stock }}">
                <button type="submit">Ajouter au panier</button>
            </form>
        @else
            <p style="color:red;">Ce produit est actuellement en rupture de stock.</p>
        @endif
    </div>
</x-app-layout>
