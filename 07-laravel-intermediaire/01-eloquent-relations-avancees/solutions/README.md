# Solutions — 07.1 Relations Eloquent avancées

## Exercice 1

```php
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('nom')->unique();
});

Schema::create('article_tag', function (Blueprint $table) {
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->primary(['article_id', 'tag_id']);
});
```
```php
// Article.php
public function tags(): BelongsToMany { return $this->belongsToMany(Tag::class); }
// Tag.php
public function articles(): BelongsToMany { return $this->belongsToMany(Article::class); }
```
```php
$article->tags()->attach($tag->id);
foreach ($article->tags as $tag) { echo $tag->nom; }
```

## Exercice 2

```blade
@foreach ($tags as $tag)
    <label>
        <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked($article->tags->contains($tag))>
        {{ $tag->nom }}
    </label>
@endforeach
```
```php
public function update(Request $request, Article $article)
{
    // ...
    $article->tags()->sync($request->input('tags', []));
    return redirect()->route('articles.show', $article);
}
```

## Exercice 3

```php
Schema::create('likes', function (Blueprint $table) {
    $table->id();
    $table->morphs('likeable');
    $table->timestamps();
});
```
```php
// Like.php
public function likeable(): MorphTo { return $this->morphTo(); }

// Article.php et Comment.php (identique dans les deux)
public function likes(): MorphMany { return $this->morphMany(Like::class, 'likeable'); }
```
```php
echo $article->likes()->count();
echo $commentaire->likes()->count();
```

## Exercice 4

```php
use Illuminate\Support\Facades\DB;

DB::listen(fn ($query) => logger($query->sql));

// Sans eager loading
$articles = Article::all();
foreach ($articles as $article) { echo $article->categorie->nom; }
// Log : 1 requête pour "all()" + 20 requêtes SELECT ... WHERE id = ? (une par catégorie)

// Avec eager loading
$articles = Article::with('categorie')->get();
foreach ($articles as $article) { echo $article->categorie->nom; }
// Log : 2 requêtes au total (articles, puis catégories IN (...))
```

## Exercice 5

```php
Schema::table('article_tag', function (Blueprint $table) {
    $table->integer('ordre')->default(0);
});
```
```php
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class)->withPivot('ordre');
}
```
```php
$tagsOrdonnes = $article->tags->sortBy('pivot.ordre');
```
