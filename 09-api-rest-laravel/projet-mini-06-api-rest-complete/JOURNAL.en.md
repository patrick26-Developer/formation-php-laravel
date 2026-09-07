# Build Journal

## Step 1 — Don't duplicate anything: reuse the level 07 domain

This project's defining decision: `Annonce`, `Category`, `Message`, `AnnoncePolicy`, `StoreAnnonceRequest`, `UpdateAnnonceRequest` come **as-is** from the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md), without a single line changed. Only a new **presentation layer** (API controllers, Resources, routes) is added on top — the concrete proof that separating business logic from presentation (already practiced in the [level 03 large project](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.en.md)) lets you expose the same substance in several forms without duplication.

## Step 2 — Resources, a mirror of level 07's Blade views

`AnnonceResource` exposes exactly the same information that `articles/show.blade.php` (module 06) and `annonces/show.blade.php` (module 07) displayed in HTML — but as structured JSON, with `whenLoaded('categorie')` and `whenLoaded('user')` to never cause an N+1 on the paginated list (module 09.2).

## Step 3 — Sanctum, not Passport

Following the practical rule from [module 09.4](../04-authentification-api-passport-oauth2/README.en.md): this API serves **your own** client (a future official mobile app), not third-party applications built by other teams. Sanctum is largely sufficient and avoids the complexity of a full OAuth2 server.

## Step 4 — Three limiters, three sensitivity levels

`AppServiceProvider::boot()` defines three distinct `RateLimiter::for()` calls: `connexion` (5/min/IP, strict against brute-force), `lecture-publique` (120/min/IP, permissive since unauthenticated and cheap), `api` (60/min/user, the default for authenticated routes). This differentiation directly reflects the table in [module 09.6](../06-rate-limiting-securite-api/README.en.md): a single global limit would have been either too strict for reads or too permissive for login.

## Step 5 — Tests focused on API security

`AnnonceApiTest` deliberately includes a test verifying that a user cannot delete another user's listing **via the API** — the same guarantee the Policy provides on the web side, but verified independently here, because a new entry surface (the API) is a new potential path for bypassing a business rule if it isn't wired correctly. The test confirms that `AnnoncePolicy::delete()` applies identically, with no rewriting.

## Going further (out of scope for this mini-project)

No v2 versioning is implemented (the topic is covered as an exercise in module 09.5), and the OpenAPI documentation remains partial (a few endpoints annotated as an example, not all of them) — to be completed as an exercise.
