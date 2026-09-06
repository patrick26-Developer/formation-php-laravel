# Solutions — 09.4 OAuth2 avec Passport

## Exercice 1

```bash
composer require laravel/passport
php artisan migrate
php artisan passport:install
# Personal access client created successfully.
# Client ID: ...
# Client secret: ...
```

## Exercice 2

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

## Exercice 3

- (a) App mobile officielle → **Sanctum** : c'est votre propre client, pas besoin du protocole OAuth2 complet.
- (b) Partenaire externe avec consentement utilisateur → **Passport** : cas d'usage exact du grant Authorization Code.
- (c) Script interne nocturne → **Passport (Client Credentials)** ou une clé d'API interne simple selon le contexte : pas d'utilisateur impliqué, mais Passport reste valide si déjà en place pour d'autres besoins.
- (d) SPA React même domaine → **Sanctum (mode cookie SPA)** : exactement le cas d'usage prévu pour ce mode.

## Exercice 4

```php
// AuthServiceProvider::boot()
Passport::tokensCan([
    'annonces:lire' => 'Lire les annonces',
    'annonces:ecrire' => 'Créer et modifier des annonces',
]);
```
```php
Route::middleware(['auth:api', 'scope:annonces:ecrire'])->post('/api/annonces', [AnnonceController::class, 'store']);
```
Un jeton obtenu avec seulement `annonces:lire` reçoit 403 sur cette route.

## Exercice 5

```markdown
# FLUX.md — Authorization Code : ComparateurAnnonces.com

1. REDIRECTION INITIALE
   ComparateurAnnonces.com → Navigateur de l'utilisateur
   "Va sur https://ma-plateforme.com/oauth/authorize?client_id=CMP&scope=annonces:lire&redirect_uri=..."

2. CONSENTEMENT
   Navigateur → ma-plateforme.com
   L'utilisateur se connecte (SUR ma-plateforme.com, jamais sur le site du
   partenaire) et voit un écran : "ComparateurAnnonces.com souhaite lire
   vos annonces. Autoriser ?" → l'utilisateur clique "Autoriser".

3. CODE TEMPORAIRE
   ma-plateforme.com → Navigateur → ComparateurAnnonces.com
   Redirection vers redirect_uri avec un code à usage unique et de courte durée :
   "https://comparateurannonces.com/callback?code=ABC123"

4. ÉCHANGE DU CODE CONTRE UN JETON
   ComparateurAnnonces.com (backend, PAS le navigateur) → ma-plateforme.com
   POST /oauth/token avec le code + client_secret (jamais exposé au navigateur)
   → reçoit un access_token utilisable pour appeler l'API au nom de l'utilisateur.
```
