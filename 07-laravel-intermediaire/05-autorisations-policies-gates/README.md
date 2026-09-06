# 07.5 — Autorisations : Policies et Gates

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre la différence entre authentification et autorisation.
- Créer et utiliser une Policy pour un modèle.
- Utiliser les Gates pour des vérifications qui ne concernent pas un modèle précis.
- Vérifier des autorisations dans les contrôleurs et les vues Blade.

## 📋 Prérequis

[07.4 — Authentification Breeze/Fortify](../04-authentification-breeze-fortify/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Authentification vs autorisation

- **Authentification** (module 07.4) : *qui* est l'utilisateur ? (connecté ou non, et lequel)
- **Autorisation** (ce module) : *que peut-il faire* ? (modifier cet article précis, supprimer ce commentaire, accéder à cette section admin)

### Créer une Policy

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

> 💡 Une Policy centralise **toutes** les règles d'autorisation d'un modèle en une seule classe — l'endroit unique où répondre à "qui peut faire quoi sur un Article", plutôt que de disperser cette logique dans chaque contrôleur ou Form Request (limite du [module 07.3](../03-middlewares-form-requests/README.md) évoquée pour des cas simples).

### Utiliser une Policy

```php
// Dans un contrôleur
public function update(Request $request, Article $article)
{
    $this->authorize('update', $article); // lève une 403 automatiquement si refusé

    // ...
}

// Ou directement, sans lever d'exception
if ($request->user()->can('update', $article)) {
    // ...
}
```

```blade
{{-- Dans une vue Blade --}}
@can('update', $article)
    <a href="{{ route('articles.edit', $article) }}">Modifier</a>
@endcan

@cannot('delete', $article)
    <p>Vous n'êtes pas autorisé à supprimer cet article.</p>
@endcannot
```

> 📌 Laravel **détecte automatiquement** quelle Policy utiliser d'après le type du modèle passé (`Article` → `ArticlePolicy`), pas besoin de l'enregistrer manuellement dans les versions récentes de Laravel (auto-découverte).

### Les Gates : pour des vérifications sans modèle associé

```php
// app/Providers/AppServiceProvider.php (méthode boot())
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

> 📌 Règle pratique : utilisez une **Policy** dès que la vérification concerne un modèle précis (`update`, `delete` sur `Article`) ; utilisez un **Gate** pour une permission plus générale, non liée à une instance particulière (accès à une section entière de l'application).

### Combiner Policy et Form Request (aller plus loin que le module 07.3)

```php
// app/Http/Requests/UpdateArticleRequest.php
public function authorize(): bool
{
    return $this->user()->can('update', $this->route('article'));
}
```

> 💡 Cette écriture délègue **toute** la logique d'autorisation à la Policy, gardant le Form Request simple et cohérent avec le reste de l'application — la centralisation évite d'avoir deux endroits différents (un Form Request, un contrôleur) qui pourraient diverger sur la même règle.

## ✅ Points clés à retenir

- Authentification = qui ; autorisation = quoi. Les Policies gèrent l'autorisation liée à un modèle précis.
- `$this->authorize()` dans un contrôleur lève automatiquement une 403 ; `can()`/`@can` vérifient sans lever d'exception.
- Un Gate convient à une permission générale, non liée à une instance de modèle.
- Centraliser l'autorisation dans une Policy évite les divergences entre contrôleur, Form Request et vue.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Authorization](https://laravel.com/docs/authorization)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [07.4 — Authentification Breeze/Fortify](../04-authentification-breeze-fortify/README.md) · **Suite :** [07.6 — Upload de fichiers et Storage](../06-upload-fichiers-storage/README.md)
