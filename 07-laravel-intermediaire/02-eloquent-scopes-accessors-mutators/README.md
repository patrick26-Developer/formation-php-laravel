# 07.2 — Scopes, accessors et mutators Eloquent

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Encapsuler des requêtes réutilisables dans des scopes locaux.
- Transformer la lecture/écriture d'un attribut avec accessors et mutators.
- Utiliser les scopes globaux pour une règle appliquée systématiquement.

## 📋 Prérequis

[07.1 — Relations Eloquent avancées](../01-eloquent-relations-avancees/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Les scopes locaux : factoriser des requêtes courantes

```php
// app/Models/Article.php
public function scopePublies($query)
{
    return $query->where('publie', true);
}

public function scopeDeLaCategorie($query, int $categorieId)
{
    return $query->where('categorie_id', $categorieId);
}
```

```php
// Utilisation : le préfixe "scope" disparaît à l'appel
Article::publies()->get();
Article::publies()->deLaCategorie(3)->latest()->get();
```

> 💡 Un scope remplace élégamment une clause dupliquée dans plusieurs contrôleurs. Comparez avec `construireFiltres()` du [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md) : même intention (factoriser une condition réutilisée), exprimée ici comme une méthode chaînable directement sur le modèle.

### Accessors : transformer un attribut à la lecture

```php
// app/Models/Article.php (syntaxe moderne, Laravel 9+)
use Illuminate\Database\Eloquent\Casts\Attribute;

protected function titre(): Attribute
{
    return Attribute::make(
        get: fn (string $value) => ucfirst($value),
    );
}

protected function extrait(): Attribute
{
    return Attribute::make(
        get: fn () => Str::limit($this->contenu, 100),
    );
}
```

```php
echo $article->titre;    // toujours avec une majuscule, quel que soit ce qui est stocké en base
echo $article->extrait;   // "extrait" n'existe pas en base : c'est un attribut CALCULÉ à la volée
```

> 📌 `extrait` n'est pas une colonne de la table `articles` : c'est un **attribut virtuel**, calculé à partir de `contenu` à chaque accès. C'est l'équivalent orienté-objet d'une fonction utilitaire comme `substr($article['contenu'], 0, 100) . '...'` que vous auriez appelée manuellement en PHP natif.

### Mutators : transformer un attribut à l'écriture

```php
protected function titre(): Attribute
{
    return Attribute::make(
        get: fn (string $value) => ucfirst($value),
        set: fn (string $value) => strtolower(trim($value)), // normalise AVANT stockage
    );
}
```

```php
$article->titre = "  MON TITRE EN MAJUSCULES  ";
$article->save();
// Stocké en base : "mon titre en majuscules" (le mutator "set" s'exécute avant l'écriture)
// Lu ensuite : "Mon titre en majuscules" (l'accessor "get" s'exécute à la lecture)
```

### Scopes globaux : une règle appliquée à TOUTES les requêtes

```php
// app/Models/Article.php
protected static function booted(): void
{
    static::addGlobalScope('publie', function (Builder $builder) {
        $builder->where('publie', true);
    });
}
```

> ⚠️ Un scope global s'applique **automatiquement à toutes les requêtes** sur ce modèle, y compris celles que vous ne contrôlez pas directement (relations chargées depuis un autre modèle). C'est puissant mais risqué : un développeur qui l'ignore peut être surpris que `Article::all()` ne retourne pas certains articles. À utiliser avec parcimonie, et toujours documenté clairement. Pour un cas ponctuel, préférez un scope **local** (`Article::publies()->get()`), plus explicite à l'endroit de l'appel.

## ✅ Points clés à retenir

- Un scope local (`scopeXxx()`) factorise une condition de requête réutilisable, appelée sans le préfixe `scope`.
- Un accessor transforme la valeur lue ; un mutator transforme la valeur avant écriture — tous deux via `Attribute::make()`.
- Un attribut peut être entièrement virtuel (calculé, sans colonne correspondante en base).
- Un scope global s'applique partout automatiquement : puissant, mais à documenter et limiter aux règles vraiment universelles.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Eloquent: Mutators & Casting](https://laravel.com/docs/eloquent-mutators)
- [laravel.com/docs — Query Scopes](https://laravel.com/docs/eloquent#query-scopes)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [07.1 — Relations Eloquent avancées](../01-eloquent-relations-avancees/README.md) · **Suite :** [07.3 — Middlewares et Form Requests](../03-middlewares-form-requests/README.md)
