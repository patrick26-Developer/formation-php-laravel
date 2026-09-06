# Solutions — 07.2 Scopes, accessors, mutators

## Exercice 1

```php
public function scopeRecents($query)
{
    return $query->where('created_at', '>=', now()->subDays(7));
}
```
```php
Article::recents()->get();
```

## Exercice 2

```php
public function scopeParCategorie($query, int $categorieId)
{
    return $query->where('categorie_id', $categorieId);
}
```
```php
Article::publies()->parCategorie(3)->get();
```

## Exercice 3

```php
protected function dureeLecture(): Attribute
{
    return Attribute::make(
        get: fn () => max(1, (int) ceil(str_word_count($this->contenu) / 200)),
    );
}
```
```php
echo $article->duree_lecture . ' min de lecture'; // ex: "3 min de lecture"
```

## Exercice 4

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
$categorie->nom = "  PHP AVANCÉ  ";
$categorie->save(); // stocké : "php avancé"
echo $categorie->nom; // affiché : "Php avancé"
```

## Exercice 5

```php
/**
 * Scope global masquant systématiquement les articles archivés de TOUTE
 * requête Eloquent sur ce modèle, y compris via des relations (Category::articles).
 * Choix : centraliser cette règle métier ("un article archivé n'existe plus
 * pour le reste de l'application") évite qu'un développeur oublie d'ajouter
 * ->where('archive', false) dans un contrôleur ou une relation future,
 * source d'un bug de sécurité/confidentialité si oublié.
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
// Pour explicitement inclure les archivés (ex: page d'administration dédiée) :
Article::withoutGlobalScope('non_archive')->get();
```
