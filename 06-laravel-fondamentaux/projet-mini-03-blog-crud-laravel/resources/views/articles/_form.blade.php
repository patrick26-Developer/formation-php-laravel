{{--
    Partiel partagé entre create.blade.php et edit.blade.php : un seul
    endroit à maintenir pour les champs du formulaire d'article, plutôt
    que deux copies qui divergeraient inévitablement avec le temps.
--}}

<div>
    <label>Catégorie</label>
    <select name="categorie_id" required>
        <option value="">-- Choisir --</option>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->id }}" @selected(old('categorie_id', $article?->categorie_id) == $categorie->id)>
                {{ $categorie->nom }}
            </option>
        @endforeach
    </select>
    @error('categorie_id') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>Titre</label>
    <input type="text" name="titre" value="{{ old('titre', $article?->titre) }}" required>
    @error('titre') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>Slug (identifiant d'URL)</label>
    <input type="text" name="slug" value="{{ old('slug', $article?->slug) }}" placeholder="mon-article-exemple" required>
    @error('slug') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>Contenu</label>
    <textarea name="contenu" rows="10" required>{{ old('contenu', $article?->contenu) }}</textarea>
    @error('contenu') <span style="color:red;">{{ $message }}</span> @enderror
</div>

<div>
    <label>
        <input type="checkbox" name="publie" value="1" @checked(old('publie', $article?->publie))>
        Publier immédiatement
    </label>
</div>
