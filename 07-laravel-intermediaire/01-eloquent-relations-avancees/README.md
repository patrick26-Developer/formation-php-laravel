# 07.1 — Relations Eloquent avancées

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Maîtriser `hasMany`, `belongsTo`, `belongsToMany`, `hasManyThrough`.
- Comprendre et utiliser les relations polymorphiques.
- Éviter systématiquement le problème N+1 avec l'eager loading.
- Utiliser les tables pivot enrichies.

## 📋 Prérequis

[Niveau 06 — Laravel Fondamentaux](../../06-laravel-fondamentaux/README.md), [04.1 — Modélisation relationnelle](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Rappel des relations de base

Déjà utilisées au [mini-projet du niveau 06](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.md) : `hasMany` (1-N côté "1") et `belongsTo` (1-N côté "N").

### `belongsToMany` : la relation N-N

```php
// app/Models/Article.php
public function tags(): BelongsToMany
{
    return $this->belongsToMany(Tag::class); // cherche automatiquement la table pivot "article_tag"
}

// app/Models/Tag.php
public function articles(): BelongsToMany
{
    return $this->belongsToMany(Article::class);
}
```

```php
// Migration de la table pivot (convention : noms des deux modèles au singulier, ordre alphabétique)
Schema::create('article_tag', function (Blueprint $table) {
    $table->foreignId('article_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->primary(['article_id', 'tag_id']);
});
```

```php
$article->tags()->attach($tagId);           // ajoute une association
$article->tags()->detach($tagId);            // retire une association
$article->tags()->sync([$id1, $id2, $id3]);   // remplace TOUTES les associations par celles-ci
$article->tags;                                 // collection des tags liés
```

> 📌 Reconnaissez la table `livre_categorie` du [module 04.1](../../04-bases-de-donnees-approfondi/01-modelisation-relationnelle-mcd-mld/README.md) : `belongsToMany` est l'automatisation Eloquent de cette table pivot que vous avez déjà conçue et interrogée manuellement en SQL.

### Table pivot enrichie (`withPivot`)

Si la table pivot porte des données propres (comme `emprunts` au module 04.1, avec ses dates) :

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
    echo $article->pivot->ajoute_le; // accède à la colonne supplémentaire de la table pivot
}
```

### Relations polymorphiques : une relation vers plusieurs types de modèles

Utile quand plusieurs modèles différents peuvent partager le même type de relation — par exemple, des commentaires pouvant être laissés sur un `Article` **ou** une `Video`.

```php
// Migration
Schema::create('comments', function (Blueprint $table) {
    $table->id();
    $table->morphs('commentable'); // crée commentable_id ET commentable_type
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
$article->comments;  // fonctionne
$video->comments;     // fonctionne aussi, MÊME TABLE comments
$commentaire->commentable; // retourne soit un Article, soit une Video, selon commentable_type
```

> 💡 Sans relation polymorphique, il aurait fallu soit deux tables (`article_comments`, `video_comments`) dupliquant la structure, soit deux colonnes de clé étrangère nullables sur `comments` (`article_id`, `video_id`) — les deux solutions moins propres que `commentable_type`/`commentable_id`.

### `hasManyThrough` : une relation indirecte

```php
// Un Pays a plusieurs Auteurs, un Auteur a plusieurs Livres.
// Country veut directement accéder à TOUS les livres de ses auteurs.
class Country extends Model
{
    public function livres(): HasManyThrough
    {
        return $this->hasManyThrough(Livre::class, Auteur::class);
    }
}
```

### Eager loading : la protection contre le problème N+1

```php
// ❌ Problème N+1 (module 03.6) : 1 requête pour les articles + N requêtes pour leurs catégories
$articles = Article::all();
foreach ($articles as $article) {
    echo $article->categorie->nom; // déclenche une requête SQL À CHAQUE itération
}

// ✅ Eager loading : 2 requêtes au total, quel que soit le nombre d'articles
$articles = Article::with('categorie')->get();
foreach ($articles as $article) {
    echo $article->categorie->nom; // déjà chargé, aucune requête supplémentaire
}

// Charger plusieurs relations, et des relations de relations
$articles = Article::with(['categorie', 'comments.article'])->get();
```

> ⚠️ **Règle professionnelle non négociable** : dès que vous accédez à une relation Eloquent **à l'intérieur d'une boucle** sur une collection, vérifiez que cette relation a été chargée avec `with()` en amont. C'est la cause la **plus fréquente** de lenteur dans une application Laravel réelle — directement héritée du problème N+1 déjà vu au [module 03.6](../../03-php-avance/06-performance-et-optimisation/README.md) et au [module 04.3](../../04-bases-de-donnees-approfondi/03-optimisation-requetes/README.md).

## ✅ Points clés à retenir

- `belongsToMany` automatise une relation N-N via une table pivot ; `withPivot()` expose ses colonnes propres.
- Les relations polymorphiques (`morphTo`/`morphMany`) évitent de dupliquer une structure pour plusieurs types de modèles liés.
- `with()` (eager loading) est la protection systématique contre le problème N+1 — à vérifier à chaque accès de relation dans une boucle.
- `attach()`/`detach()`/`sync()` gèrent les associations d'une relation N-N sans SQL manuel.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Eloquent: Relationships](https://laravel.com/docs/eloquent-relationships)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 06 — Laravel Fondamentaux](../../06-laravel-fondamentaux/README.md) · **Suite :** [07.2 — Scopes, accessors, mutators](../02-eloquent-scopes-accessors-mutators/README.md)
