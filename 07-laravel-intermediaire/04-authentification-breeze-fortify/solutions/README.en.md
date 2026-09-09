# Solutions — 07.4 Authentication with Breeze/Fortify

## Exercise 1

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
php artisan serve
```
Visit `/register`, create an account, then `/login` with those credentials.

## Exercise 2

In `RegisteredUserController::store()`:
```php
'password' => Hash::make($request->password),
```
(or automatic if the `hashed` cast is used on the model). In
`AuthenticatedSessionController::store()`:
```php
$request->authenticate();
$request->session()->regenerate();
```
`regenerate()` is the direct equivalent of `session_regenerate_id(true)`
used in the level 02 mini-project, against session fixation.

## Exercise 3

```php
Route::resource('articles', ArticleController::class)
    ->except(['index', 'show']); // edit/delete routes protected

Route::middleware('auth')->group(function () {
    Route::resource('articles', ArticleController::class)->except(['index', 'show']);
});

// index and show stay outside the "auth" group, so they're public
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
```

## Exercise 4

```blade
@auth
    <span>Hello, {{ auth()->user()->name }}</span>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Log out</button>
    </form>
@else
    <a href="{{ route('login') }}">Log in</a>
    <a href="{{ route('register') }}">Register</a>
@endauth
```

## Exercise 5

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
<p>By {{ $article->user?->name ?? 'Unknown author' }}</p>
```
`nullOnDelete()` rather than `cascadeOnDelete()`: deleting a user
shouldn't necessarily delete their articles — a deliberate business
choice, to document in the code (a real project's JOURNAL).
