<x-app-layout>
    <div class="p-6">
        <h1>Catalogue</h1>

        @if (session('succes')) <p style="color:green">{{ session('succes') }}</p> @endif
        @if (session('erreur')) <p style="color:red">{{ session('erreur') }}</p> @endif

        <form method="GET">
            <input type="text" name="recherche" placeholder="Rechercher..." value="{{ request('recherche') }}">
            <select name="categorie">
                <option value="">Toutes catégories</option>
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" @selected(request('categorie') == $categorie->id)>{{ $categorie->nom }}</option>
                @endforeach
            </select>
            <button type="submit">Filtrer</button>
        </form>

        <div style="display:grid; grid-template-columns: repeat(4, 1fr); gap:1rem;">
            @foreach ($products as $product)
                <div style="border:1px solid #ccc; padding:1rem;">
                    <h3><a href="{{ route('products.show', $product) }}">{{ $product->nom }}</a></h3>
                    <p>{{ number_format($product->prix, 2) }} €</p>
                    <p>{{ $product->estEnStock() ? 'En stock' : 'Rupture de stock' }}</p>
                </div>
            @endforeach
        </div>

        {{ $products->links() }}
    </div>
</x-app-layout>
