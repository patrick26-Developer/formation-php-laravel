# Solutions — 08.2 Cache et optimisation de performance

## Exercice 1

```php
$categories = Cache::remember('categories.toutes', now()->addHour(), function () {
    return Category::orderBy('nom')->get();
});
```
Avec `DB::listen()` actif : la requête `SELECT * FROM categories...` n'apparaît
qu'au PREMIER chargement ; les suivants ne déclenchent aucune requête tant
que le cache n'a pas expiré.

## Exercice 2

```php
public function store(Request $request): RedirectResponse
{
    $data = $request->validate([/* ... */]);
    Category::create($data);
    Cache::forget('categories.toutes');
    return redirect()->route('categories.index');
}
```

## Exercice 3

```php
// app/Models/Category.php
protected static function booted(): void
{
    static::saved(fn () => Cache::forget('categories.toutes'));
    static::deleted(fn () => Cache::forget('categories.toutes'));
}
```
Avantage sur l'exercice 2 : fonctionne aussi via Tinker, un seeder, ou
toute future fonctionnalité de modification en masse — pas seulement
le contrôleur `store()`.

## Exercice 4

```php
$nombreAnnonces = Cache::remember(
    "annonces.actives.count.{$user->id}",
    now()->addMinutes(15),
    fn () => $user->annonces()->where('active', true)->count()
);
```
Testé avec deux comptes différents : chacun obtient sa propre valeur en
cache, sous des clés distinctes (`annonces.actives.count.1`,
`annonces.actives.count.2`).

## Exercice 5

```php
// Sans cache
$debut = microtime(true);
$annonces = Annonce::with('categorie')->actives()->paginate(9);
echo (microtime(true) - $debut) * 1000 . " ms\n"; // ex: 45 ms

// Avec cache déjà rempli
$debut = microtime(true);
$annonces = Cache::remember('annonces.page.1', 3600, fn () => Annonce::with('categorie')->actives()->paginate(9));
echo (microtime(true) - $debut) * 1000 . " ms\n"; // ex: 2 ms
```
Gain typique observé : d'un facteur 10 à 50 selon le volume de données et
la complexité de la requête évitée.

Sur un fil d'actualité en temps réel, le gain serait quasi nul car la
donnée change à chaque requête (ou presque) : le cache serait invalidé
aussi souvent qu'il serait lu, ajoutant la complexité de gestion du cache
sans bénéfice réel — le cache est rentable uniquement quand une donnée
est lue BEAUCOUP plus souvent qu'elle n'est modifiée.
