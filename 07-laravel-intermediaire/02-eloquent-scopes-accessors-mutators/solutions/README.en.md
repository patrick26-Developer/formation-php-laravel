# Solutions — 07.2 Scopes, Accessors, Mutators

## Exercise 1

```php
public function scopeRecents($query)
{
    return $query->where('created_at', '>=', now()->subDays(7));
}
```
```php
Article::recents()->get();
```

## Exercise 2

```php
public function scopeParCategorie($query, int $categorieId)
{
    return $query->where('categorie_id', $categorieId);
}
```
```php
Article::publies()->parCategorie(3)->get();
```

## Exercise 3

```php
protected function dureeLecture(): Attribute
{
    return Attribute::make(
        get: fn () => max(1, (int) ceil(str_word_count($this->contenu) / 200)),
    );
}
```
```php
echo $article->duree_lecture . ' min read'; // e.g.: "3 min read"
```

## Exercise 4

```php
protected function nom(): Attribute
{
    return Attribute::make(
        get: fn (string $value) => ucfirst($value),
        set: fn (string $value) => strtolower(trim($value)),
    );
}
```
```php
$categorie->nom = "  ADVANCED PHP  ";
$categorie->save(); // stored as: "advanced php"
echo $categorie->nom; // displayed as: "Advanced php"
```

## Exercise 5

```php
/**
 * Global scope systematically hiding archived articles from ANY Eloquent
 * query on this model, including via relationships (Category::articles).
 * Rationale: centralizing this business rule ("an archived article no
 * longer exists for the rest of the application") avoids a developer
 * forgetting to add ->where('archive', false) in a controller or a future
 * relationship — a security/privacy bug if forgotten.
 */
class Article extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('non_archive', function (Builder $builder) {
            $builder->where('archive', false);
        });
    }
}
```
```php
// To explicitly include archived ones (e.g., a dedicated admin page):
Article::withoutGlobalScope('non_archive')->get();
```
