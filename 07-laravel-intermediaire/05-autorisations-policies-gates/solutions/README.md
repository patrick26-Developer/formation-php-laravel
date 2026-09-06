# Solutions — 07.5 Autorisations : Policies et Gates

## Exercice 1

```bash
php artisan make:policy ArticlePolicy --model=Article
```
```php
class ArticlePolicy
{
    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }
}
```
```php
public function update(Request $request, Article $article)
{
    $this->authorize('update', $article);
    // ...
}
```

## Exercice 2

```blade
@can('update', $article)
    <a href="{{ route('articles.edit', $article) }}">Modifier</a>
@endcan

@can('delete', $article)
    <form method="POST" action="{{ route('articles.destroy', $article) }}">
        @csrf @method('DELETE')
        <button type="submit">Supprimer</button>
    </form>
@endcan
```

## Exercice 3

```php
// AppServiceProvider::boot()
Gate::define('acceder-admin', fn (User $user) => $user->est_admin);
```
```php
Route::get('/admin', [AdminController::class, 'index'])->can('acceder-admin');
```

## Exercice 4

```php
public function delete(User $user, Article $article): bool
{
    return $user->id === $article->user_id || $user->est_admin;
}
```
Testé : l'auteur peut supprimer (première condition vraie), un admin non
auteur peut aussi supprimer (seconde condition vraie), un tiers non-admin
et non-auteur reçoit un 403 (les deux conditions sont fausses).

## Exercice 5

```php
class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('article'));
    }
    // ...
}
```
Avantage : si la règle d'autorisation change (par exemple, ajouter "ou
modérateur"), une seule modification dans `ArticlePolicy::update()` suffit
— avant cette délégation, il aurait fallu répercuter le changement dans
CHAQUE endroit qui dupliquait la logique (contrôleur, Form Request, vue),
avec le risque d'en oublier un et de laisser une incohérence de sécurité.
