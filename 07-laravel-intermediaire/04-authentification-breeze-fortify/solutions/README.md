# Solutions — 07.4 Authentification Breeze/Fortify

## Exercice 1

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
php artisan serve
```
Visitez `/register`, créez un compte, puis `/login` avec ces identifiants.

## Exercice 2

Dans `RegisteredUserController::store()` :
```php
'password' => Hash::make($request->password),
```
(ou automatique si le cast `hashed` est utilisé sur le modèle). Dans
`AuthenticatedSessionController::store()` :
```php
$request->authenticate();
$request->session()->regenerate();
```
`regenerate()` est l'équivalent direct de `session_regenerate_id(true)`
utilisé au mini-projet du niveau 02, contre la fixation de session.

## Exercice 3

```php
Route::resource('articles', ArticleController::class)
    ->except(['index', 'show']); // routes de modification protégées

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
});

// index et show restent hors du groupe "auth", donc publics
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
```

## Exercice 4

```blade
@auth
    <span>Bonjour, {{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Déconnexion</button>
    </form>
@else
    <a href="{{ route('login') }}">Connexion</a>
    <a href="{{ route('register') }}">Inscription</a>
@endauth
```

## Exercice 5

```php
Schema::table('articles', function (Blueprint $table) {
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
});
```
```php
public function store(StoreArticleRequest $request): RedirectResponse
{
    $article = $request->validated();
    $article['user_id'] = $request->user()->id;

    Article::create($article);

    return redirect()->route('articles.index');
}
```
```php
public function show(Article $article): View
{
    $article->load(['categorie', 'user', 'comments']);
    return view('articles.show', compact('article'));
}
```
```blade
<p>Par {{ $article->user?->name ?? 'Auteur inconnu' }}</p>
```
`nullOnDelete()` plutôt que `cascadeOnDelete()` : supprimer un utilisateur
ne doit pas nécessairement supprimer ses articles — un choix métier
délibéré, à documenter dans le code (JOURNAL du projet réel).
