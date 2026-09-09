# Solutions — 06.2 Routing and Controllers

## Exercise 1

```php
// routes/web.php
Route::get('/', fn () => 'Home page');
Route::get('/a-propos', fn () => 'About us');
Route::get('/contact', fn () => 'Contact us');
```

## Exercise 2

```bash
php artisan make:controller ArticleController
```
```php
// app/Http/Controllers/ArticleController.php
public function index()
{
    return view('articles.index');
}
```
```blade
{{-- resources/views/articles/index.blade.php --}}
<h1>Article list</h1>
```
```php
Route::get('/articles', [ArticleController::class, 'index']);
```

## Exercise 3

```bash
php artisan make:model Article -m
```
```php
// database/migrations/xxxx_create_articles_table.php
Schema::create('articles', function (Blueprint $table) {
    $table->id();
    $table->string('titre');
    $table->text('contenu');
    $table->timestamps();
});
```
```php
Route::get('/articles/{article}', [ArticleController::class, 'show']);
```
```php
public function show(Article $article)
{
    return $article->titre;
}
```
A non-existent ID (`/articles/9999`) automatically returns a Laravel 404 page, with no extra code — Laravel internally calls `Article::findOrFail($id)`.

## Exercise 4

```bash
php artisan make:controller ArticleController --resource
```
```php
Route::resource('articles', ArticleController::class);
```
```bash
php artisan route:list --name=articles
# Shows the 7 lines: index, create, store, show, edit, update, destroy
```

## Exercise 5

```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/parametres', [AdminController::class, 'parametres'])->name('parametres');
});
```
```php
// In a controller
return redirect()->route('admin.dashboard');
```
```bash
php artisan route:list --name=admin
# GET /admin/tableau-de-bord ... admin.dashboard
# GET /admin/parametres ... admin.parametres
```
