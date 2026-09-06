# Solutions — 07.6 Upload de fichiers et Storage

## Exercice 1

```php
Schema::table('articles', fn (Blueprint $t) => $t->string('image')->nullable());
```
```php
$request->validate(['image' => 'nullable|image|mimes:jpg,png|max:2048']);

$data = $request->validated();
if ($request->hasFile('image')) {
    $data['image'] = $request->file('image')->store('articles', 'public');
}
Article::create($data);
```

## Exercice 2

```php
protected function imageUrl(): Attribute
{
    return Attribute::make(
        get: fn () => $this->image
            ? Storage::disk('public')->url($this->image)
            : asset('images/placeholder.png'),
    );
}
```
```blade
<img src="{{ $article->image_url }}" alt="{{ $article->titre }}">
```

## Exercice 3

```php
if ($request->hasFile('image')) {
    if ($article->image) {
        Storage::disk('public')->delete($article->image);
    }
    $article->image = $request->file('image')->store('articles', 'public');
}
```

## Exercice 4

```php
$request->validate([
    'image' => 'nullable|image|mimes:jpg,png|max:2048|dimensions:min_width=300,min_height=200',
]);
```
Avec une image de 100x100px : message "The image has invalid image dimensions."
(personnalisable via le fichier de langue de validation).

## Exercice 5

```php
// app/Models/Article.php
protected static function booted(): void
{
    static::deleting(function (Article $article) {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
    });
}
```
Avantage : ce nettoyage s'exécute désormais **quel que soit l'endroit**
d'où la suppression est déclenchée — `$article->delete()` dans un
contrôleur, via Tinker, dans une commande Artisan planifiée, ou une future
fonctionnalité d'administration en masse. Une suppression codée uniquement
dans `ArticleController::destroy()` serait contournée par n'importe quel
autre chemin de suppression, laissant des fichiers orphelins — le Model
Event centralise la règle au bon endroit : le modèle lui-même, garant de
son propre cycle de vie.
