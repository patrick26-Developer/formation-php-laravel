# Solutions — 06.2 Routing et Controllers

## Exercice 1

```php
// routes/web.php
Route::get('/', fn () => 'Page d\'accueil');
Route::get('/a-propos', fn () => 'À propos de nous');
Route::get('/contact', fn () => 'Contactez-nous');
```

## Exercice 2

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
<h1>Liste des articles</h1>
```
```php
Route::get('/articles', [ArticleController::class, 'index']);
```

## Exercice 3

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
Un ID inexistant (`/articles/9999`) renvoie automatiquement une page 404 Laravel, sans code supplémentaire — Laravel appelle en interne `Article::findOrFail($id)`.

## Exercice 4

```bash
php artisan make:controller ArticleController --resource
```
```php
Route::resource('articles', ArticleController::class);
```
```bash
php artisan route:list --name=articles
# Affiche les 7 lignes : index, create, store, show, edit, update, destroy
```

## Exercice 5

```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/tableau-de-bord', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/parametres', [AdminController::class, 'parametres'])->name('parametres');
});
```
```php
// Dans un contrôleur
return redirect()->route('admin.dashboard');
```
```bash
php artisan route:list --name=admin
# GET /admin/tableau-de-bord ... admin.dashboard
# GET /admin/parametres ... admin.parametres
```
