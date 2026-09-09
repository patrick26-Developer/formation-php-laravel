# Solutions — 08.2 Cache and Performance Optimization

## Exercise 1

```php
$categories = Cache::remember('categories.toutes', now()->addHour(), function () {
    return Category::orderBy('nom')->get();
});
```
With `DB::listen()` active: the `SELECT * FROM categories...` query only
appears on the FIRST load; subsequent ones trigger no query as long as
the cache hasn't expired.

## Exercise 2

```php
public function store(Request $request): RedirectResponse
{
    $data = $request->validate([/* ... */]);
    Category::create($data);
    Cache::forget('categories.toutes');
    return redirect()->route('categories.index');
}
```

## Exercise 3

```php
// app/Models/Category.php
protected static function booted(): void
{
    static::saved(fn () => Cache::forget('categories.toutes'));
    static::deleted(fn () => Cache::forget('categories.toutes'));
}
```
Benefit over exercise 2: also works via Tinker, a seeder, or any future
bulk-edit feature — not just the `store()` controller.

## Exercise 4

```php
$nombreAnnonces = Cache::remember(
    "annonces.actives.count.{$user->id}",
    now()->addMinutes(15),
    fn () => $user->annonces()->where('active', true)->count()
);
```
Tested with two different accounts: each gets its own cached value,
under distinct keys (`annonces.actives.count.1`,
`annonces.actives.count.2`).

## Exercise 5

```php
// Without cache
$debut = microtime(true);
$annonces = Annonce::with('categorie')->actives()->paginate(9);
echo (microtime(true) - $debut) * 1000 . " ms\n"; // e.g.: 45 ms

// With cache already filled
$debut = microtime(true);
$annonces = Cache::remember('annonces.page.1', 3600, fn () => Annonce::with('categorie')->actives()->paginate(9));
echo (microtime(true) - $debut) * 1000 . " ms\n"; // e.g.: 2 ms
```
Typical observed gain: a factor of 10 to 50 depending on the data
volume and the complexity of the avoided query.

On a real-time news feed, the gain would be nearly zero because the
data changes on almost every request: the cache would be invalidated
as often as it's read, adding cache-management complexity with no real
benefit — caching only pays off when data is read MUCH more often than
it's modified.
