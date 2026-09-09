# Solutions — 07.5 Authorization: Policies and Gates

## Exercise 1

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

## Exercise 2

```blade
@can('update', $article)
    <a href="{{ route('articles.edit', $article) }}">Edit</a>
@endcan

@can('delete', $article)
    <form method="POST" action="{{ route('articles.destroy', $article) }}">
        @csrf @method('DELETE')
        <button type="submit">Delete</button>
    </form>
@endcan
```

## Exercise 3

```php
// AppServiceProvider::boot()
Gate::define('acceder-admin', fn (User $user) => $user->est_admin);
```
```php
Route::get('/admin', [AdminController::class, 'index'])->can('acceder-admin');
```

## Exercise 4

```php
public function delete(User $user, Article $article): bool
{
    return $user->id === $article->user_id || $user->est_admin;
}
```
Tested: the author can delete (first condition true), a non-author
admin can also delete (second condition true), a non-admin non-author
third party gets a 403 (both conditions false).

## Exercise 5

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
Benefit: if the authorization rule changes (for example, adding "or
moderator"), a single change in `ArticlePolicy::update()` is enough —
before this delegation, the change would have had to be replicated in
EVERY place duplicating the logic (controller, Form Request, view),
risking missing one and leaving a security inconsistency.
