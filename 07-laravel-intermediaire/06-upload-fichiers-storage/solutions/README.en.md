# Solutions — 07.6 File Uploads and Storage

## Exercise 1

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

## Exercise 2

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

## Exercise 3

```php
if ($request->hasFile('image')) {
    if ($article->image) {
        Storage::disk('public')->delete($article->image);
    }
    $article->image = $request->file('image')->store('articles', 'public');
}
```

## Exercise 4

```php
$request->validate([
    'image' => 'nullable|image|mimes:jpg,png|max:2048|dimensions:min_width=300,min_height=200',
]);
```
With a 100x100px image: message "The image has invalid image dimensions."
(customizable via the validation language file).

## Exercise 5

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
Benefit: this cleanup now runs **no matter where** the deletion is
triggered from — `$article->delete()` in a controller, via Tinker, in a
scheduled Artisan command, or a future bulk-admin feature. Deletion
coded only inside `ArticleController::destroy()` would be bypassed by
any other deletion path, leaving orphaned files — the Model Event
centralizes the rule in the right place: the model itself, the
guardian of its own lifecycle.
