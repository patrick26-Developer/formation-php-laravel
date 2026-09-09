# Solutions — 09.4 OAuth2 with Passport

## Exercise 1

```bash
composer require laravel/passport
php artisan migrate
php artisan passport:install
# Personal access client created successfully.
# Client ID: ...
# Client secret: ...
```

## Exercise 2

```php
Route::middleware('client')->get('/api/stats-globales', function () {
    return response()->json(['total_annonces' => Annonce::count()]);
});
```
```bash
curl -X POST http://localhost:8000/oauth/token \
  -d "grant_type=client_credentials&client_id=XXX&client_secret=YYY&scope="
# {"token_type":"Bearer","expires_in":..., "access_token":"..."}

curl http://localhost:8000/api/stats-globales -H "Authorization: Bearer <access_token>"
```

## Exercise 3

- (a) Official mobile app → **Sanctum**: it's your own client, no need for the full OAuth2 protocol.
- (b) External partner with user consent → **Passport**: exactly the Authorization Code grant's use case.
- (c) Internal overnight script → **Passport (Client Credentials)** or a simple internal API key depending on context: no user involved, but Passport remains valid if already in place for other needs.
- (d) Same-domain React SPA → **Sanctum (SPA cookie mode)**: exactly the use case this mode was designed for.

## Exercise 4

```php
// AuthServiceProvider::boot()
Passport::tokensCan([
    'annonces:lire' => 'Read listings',
    'annonces:ecrire' => 'Create and edit listings',
]);
```
```php
Route::middleware(['auth:api', 'scope:annonces:ecrire'])->post('/api/annonces', [AnnonceController::class, 'store']);
```
A token obtained with only `annonces:lire` gets 403 on this route.

## Exercise 5

```markdown
# FLUX.md — Authorization Code: ComparateurAnnonces.com

1. INITIAL REDIRECT
   ComparateurAnnonces.com → the user's browser
   "Go to https://ma-plateforme.com/oauth/authorize?client_id=CMP&scope=annonces:lire&redirect_uri=..."

2. CONSENT
   Browser → ma-plateforme.com
   The user logs in (ON ma-plateforme.com, never on the partner's site)
   and sees a screen: "ComparateurAnnonces.com wants to read your
   listings. Allow?" → the user clicks "Allow".

3. TEMPORARY CODE
   ma-plateforme.com → Browser → ComparateurAnnonces.com
   Redirect to redirect_uri with a single-use, short-lived code:
   "https://comparateurannonces.com/callback?code=ABC123"

4. EXCHANGING THE CODE FOR A TOKEN
   ComparateurAnnonces.com (backend, NOT the browser) → ma-plateforme.com
   POST /oauth/token with the code + client_secret (never exposed to the browser)
   → receives an access_token usable to call the API on the user's behalf.
```
