# 07.5 — Authorization: Policies and Gates

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the difference between authentication and authorization.
- Create and use a Policy for a model.
- Use Gates for checks that don't relate to a specific model.
- Check authorization in controllers and Blade views.

## 📋 Prerequisites

[07.4 — Authentication with Breeze/Fortify](../04-authentification-breeze-fortify/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Authentication vs authorization

- **Authentication** (module 07.4): *who* is the user? (logged in or not, and which one)
- **Authorization** (this module): *what can they do?* (edit this specific article, delete this comment, access this admin section)

### Creating a Policy

```bash
php artisan make:policy ArticlePolicy --model=Article
```

```php
// app/Policies/ArticlePolicy.php
class ArticlePolicy
{
    public function update(User $user, Article $article): bool
    {
        return $user->id === $article->user_id;
    }

    public function delete(User $user, Article $article): bool
    {
        return $user->id === $article->user_id || $user->est_admin;
    }
}
```

> 💡 A Policy centralizes **every** authorization rule for a model into a single class — the one place to answer "who can do what on an Article", rather than scattering this logic across every controller or Form Request (a limitation of [module 07.3](../03-middlewares-form-requests/README.en.md) noted for simple cases).

### Using a Policy

```php
// In a controller
public function update(Request $request, Article $article)
{
    $this->authorize('update', $article); // automatically throws a 403 if denied

    // ...
}

// Or directly, without throwing an exception
if ($request->user()->can('update', $article)) {
    // ...
}
```

```blade
{{-- In a Blade view --}}
@can('update', $article)
    <a href="{{ route('articles.edit', $article) }}">Edit</a>
@endcan

@cannot('delete', $article)
    <p>You are not authorized to delete this article.</p>
@endcannot
```

> 📌 Laravel **automatically detects** which Policy to use based on the type of the model passed (`Article` → `ArticlePolicy`), no need to register it manually in recent Laravel versions (auto-discovery).

### Gates: for checks with no associated model

```php
// app/Providers/AppServiceProvider.php (boot() method)
use Illuminate\Support\Facades\Gate;

Gate::define('acceder-tableau-de-bord', function (User $user) {
    return $user->est_admin;
});
```

```php
if (Gate::allows('acceder-tableau-de-bord')) {
    // ...
}
```

```blade
@can('acceder-tableau-de-bord')
    <a href="/admin">Administration</a>
@endcan
```

> 📌 Practical rule: use a **Policy** as soon as the check concerns a specific model (`update`, `delete` on `Article`); use a **Gate** for a more general permission, not tied to a particular instance (access to an entire section of the application).

### Combining Policy and Form Request (going beyond module 07.3)

```php
// app/Http/Requests/UpdateArticleRequest.php
public function authorize(): bool
{
    return $this->user()->can('update', $this->route('article'));
}
```

> 💡 This delegates **all** authorization logic to the Policy, keeping the Form Request simple and consistent with the rest of the application — centralizing it avoids having two different places (a Form Request, a controller) that could drift apart on the same rule.

## ✅ Key takeaways

- Authentication = who; authorization = what. Policies handle authorization tied to a specific model.
- `$this->authorize()` in a controller automatically throws a 403; `can()`/`@can` check without throwing an exception.
- A Gate suits a general permission, not tied to a model instance.
- Centralizing authorization in a Policy avoids drift between controller, Form Request, and view.

## ➡️ Going further

- [laravel.com/docs — Authorization](https://laravel.com/docs/authorization)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [07.4 — Authentication with Breeze/Fortify](../04-authentification-breeze-fortify/README.en.md) · **Next:** [07.6 — File Uploads and Storage](../06-upload-fichiers-storage/README.en.md)
