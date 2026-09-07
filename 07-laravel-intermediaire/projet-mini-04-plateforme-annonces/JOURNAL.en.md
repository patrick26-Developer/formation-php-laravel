# Build Journal

## Step 1 — Starting from Breeze, not from scratch

Unlike the level 06 blog (no authentication, by pedagogical choice), this project **starts** with installing Breeze (module 07.4). All the register/login/logout mechanics are already generated and battle-tested by the Laravel community — this mini-project's work focuses on what's **added on top**: the classifieds business logic.

## Step 2 — The schema: four tables, two kinds of relationships

`categories` → `annonces` (classic 1-N, like the blog), `annonces` → `messages` (1-N, contact messages), and `favorites` (N-N pivot table between `users` and `annonces`, with no extra column — just `withTimestamps()` to know when the favorite was added). Notice `restrictOnDelete()` on `categorie_id` instead of `cascadeOnDelete()` as in the blog: deleting a category that has active listings is **deliberately blocked**, to avoid accidentally deleting real users' listings — a different business choice than the blog's, where articles were less "precious".

## Step 3 — The Policy before the controller

`AnnoncePolicy` is written **before** wiring anything into `AnnonceController`: both `update()` and `delete()` check `$user->id === $annonce->user_id`. `UpdateAnnonceRequest::authorize()` delegates entirely to this Policy (`$this->user()?->can('update', ...)`) rather than duplicating the condition — the same centralization recommended in exercise 5 of [module 07.5](../05-autorisations-policies-gates/README.en.md). The controller itself calls `$this->authorize()` in `edit()`/`destroy()`: three entry points (Form Request, controller, view via `@can`) that all query the **same** source of truth.

## Step 4 — Upload, from the form to cleanup

`StoreAnnonceRequest`/`UpdateAnnonceRequest` validate the image (`image|mimes:...|max:2048`). The controller handles replacement (deleting the old file before storing the new one, module 07.6). Permanent deletion is delegated to a **Model Event** (`static::deleting()` in `Annonce::booted()`) rather than to the controller: this way, no matter how a listing is deleted (interface, Tinker, a future moderation command), its image file is **always** cleaned up — the same logic as exercise 5 of module 07.6.

## Step 5 — The notification, triggered by an anonymous visitor

The most interesting point of this project: `MessageController::store()` is a **public** route (no `middleware('auth')`), yet it triggers `$annonce->user->notify(...)` — a notification to an **authenticated** user, caused by an action from a visitor who is not. This is an important reminder: authentication protects **actions**, not the ability to **trigger an effect** on a logged-in user's account through a mechanism built for that purpose (here, a public contact form — a legitimate use case).

## Step 6 — Favorites, the simplest N-N relationship

`favoris()` on `User` and `favoritedBy()` on `Annonce` are plain `belongsToMany` calls with no custom pivot column (unlike a case requiring `withPivot`, seen in module 07.1). `FavoriteController::toggle()` illustrates the conditional `attach()`/`detach()` pattern — an alternative to `sync()` when managing a single relationship at a time rather than a whole set.

## Going further (out of scope for this mini-project)

No limit is placed on the number of listings per user, no moderation exists before publishing, and messages themselves aren't protected against spam (no CAPTCHA or rate limiting). These topics, especially **rate limiting**, are covered in detail in [module 09.6](../../09-api-rest-laravel/06-rate-limiting-securite-api/README.md) *(French only)*.
