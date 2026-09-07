# 07.1 — Advanced Eloquent Relationships

> **Status:** ✅ Available

## 🎯 Objectives

- Master `hasMany`, `belongsTo`, `belongsToMany`, `hasManyThrough`.
- Understand and use polymorphic relationships.
- Systematically avoid the N+1 problem with eager loading.
- Use enriched pivot tables.

## 📋 Prerequisites

[Level 06 — Laravel Fundamentals](../../06-laravel-fondamentaux/README.en.md), [04.1 — Relational Modeling](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Recap of the basic relationships

Already used in the [level 06 mini-project](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.en.md): `hasMany` (1-N on the "1" side) and `belongsTo` (1-N on the "N" side).

### `belongsToMany`: the N-N relationship

```php
// app/Models/Article.php
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class); // automatically looks for the "article_tag" pivot table
}

// app/Models/Tag.php
public function articles(): BelongsToMany
{
    return $this->belongsToMany(Article::class);
}
```

```php
// Pivot table migration (convention: both model names, singular, alphabetical order)
Schema::create('article_tag', function (Blueprint $table) {
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->primary(['article_id', 'tag_id']);
});
```

```php
$article->tags()->attach($tagId);           // adds an association
$article->tags()->detach($tagId);            // removes an association
$article->tags()->sync([$id1, $id2, $id3]);   // replaces ALL associations with these
$article->tags;                                 // collection of linked tags
```

> 📌 Recognize the `livre_categorie` table from [module 04.1](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.en.md): `belongsToMany` is the Eloquent automation of that pivot table you already designed and queried manually in SQL.

### Enriched pivot table (`withPivot`)

If the pivot table carries its own data (like `emprunts` in module 04.1, with its dates):

```php
public function articles(): BelongsToMany
{
    return $this->belongsToMany(Article::class)
        ->withPivot('ajoute_le')
        ->withTimestamps();
}
```

```php
foreach ($tag->articles as $article) {
    echo $article->pivot->ajoute_le; // accesses the pivot table's extra column
}
```

### Polymorphic relationships: one relationship to several model types

Useful when several different models can share the same type of relationship — for example, comments that can be left on either an `Article` **or** a `Video`.

```php
// Migration
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->morphs('commentable'); // creates commentable_id AND commentable_type
    $table->text('contenu');
    $table->timestamps();
});
```

```php
// app/Models/Comment.php
public function commentable(): MorphTo
{
    return $this->morphTo();
}

// app/Models/Article.php
public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}

// app/Models/Video.php
public function comments(): MorphMany
{
    return $this->morphMany(Comment::class, 'commentable');
}
```

```php
$article->comments;  // works
$video->comments;     // also works, the SAME comments table
$comment->commentable; // returns either an Article or a Video, depending on commentable_type
```

> 💡 Without a polymorphic relationship, you would have needed either two tables (`article_comments`, `video_comments`) duplicating the structure, or two nullable foreign key columns on `comments` (`article_id`, `video_id`) — both solutions less clean than `commentable_type`/`commentable_id`.

### `hasManyThrough`: an indirect relationship

```php
// A Country has several Authors, an Author has several Books.
// Country wants direct access to ALL the books of its authors.
class Country extends Model
{
    public function livres(): HasManyThrough
    {
        return $this->hasManyThrough(Livre::class, Auteur::class);
    }
}
```

### Eager loading: protection against the N+1 problem

```php
// ❌ N+1 problem (module 03.6): 1 query for the articles + N queries for their categories
$articles = Article::all();
foreach ($articles as $article) {
    echo $article->categorie->nom; // triggers a SQL query on EVERY iteration
}

// ✅ Eager loading: 2 queries total, no matter how many articles
$articles = Article::with('categorie')->get();
foreach ($articles as $article) {
    echo $article->categorie->nom; // already loaded, no extra query
}

// Loading several relationships, and relationships of relationships
$articles = Article::with(['categorie', 'comments.article'])->get();
```

> ⚠️ **Non-negotiable professional rule**: as soon as you access an Eloquent relationship **inside a loop** over a collection, make sure that relationship was loaded with `with()` beforehand. This is the **most frequent** cause of slowness in a real Laravel application — directly inherited from the N+1 problem already seen in [module 03.6](../../03-php-avance/06-performance-et-optimisation/README.en.md) and [module 04.3](../../04-bases-de-donnees-approfondi/03-optimisation-requetes/README.en.md).

## ✅ Key takeaways

- `belongsToMany` automates an N-N relationship via a pivot table; `withPivot()` exposes its own columns.
- Polymorphic relationships (`morphTo`/`morphMany`) avoid duplicating a structure for several linked model types.
- `with()` (eager loading) is the systematic protection against the N+1 problem — check it on every relationship access inside a loop.
- `attach()`/`detach()`/`sync()` manage an N-N relationship's associations without manual SQL.

## ➡️ Going further

- [laravel.com/docs — Eloquent: Relationships](https://laravel.com/docs/eloquent-relationships)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [Level 06 — Laravel Fundamentals](../../06-laravel-fondamentaux/README.en.md) · **Next:** [07.2 — Scopes, Accessors, Mutators](../02-eloquent-scopes-accessors-mutators/README.en.md)
