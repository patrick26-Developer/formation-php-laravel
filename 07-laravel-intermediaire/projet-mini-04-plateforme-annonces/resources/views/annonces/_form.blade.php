<div>
    <label>Catégorie</label>
    <select name="categorie_id" required>
        <option value="">-- Choisir --</option>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}" @selected(old('categorie_id', $annonce?->categorie_id) == $categorie->id)>
                {{ $categorie->nom }}
            </option>
        @endforeach
    </select>
    @error('categorie_id') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>Titre</label>
    <input type="text" name="titre" value="{{ old('titre', $annonce?->titre) }}" required>
    @error('titre') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>Description</label>
    <textarea name="description" rows="6" required>{{ old('description', $annonce?->description) }}</textarea>
    @error('description') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>Prix (€)</label>
    <input type="number" step="0.01" name="prix" value="{{ old('prix', $annonce?->prix) }}" required>
    @error('prix') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>Photo</label>
    <input type="file" name="image" accept="image/*">
    @error('image') <span style="color:red;">{{ $message }}</span> @enderror
    @if ($annonce?->image_url)
        <img src="{{ $annonce->image_url }}" width="100" alt="Image actuelle">
    @endif
</div>
