# Solutions — 09.6 Rate limiting et sécurité des API

## Exercice 1

```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```
```bash
for i in {1..70}; do curl -s -o /dev/null -w "%{http_code}\n" http://localhost:8000/api/annonces; done
# Les ~10 dernières lignes affichent 429 au lieu de 200
```

## Exercice 2

```php
RateLimiter::for('connexion', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
```
```php
Route::post('/api/login', [AuthController::class, 'login'])->middleware('throttle:connexion');
```
Les 6e, 7e... tentatives dans la même minute reçoivent 429, quel que soit
le contenu envoyé — même avant que la logique de connexion elle-même ne
s'exécute.

## Exercice 3

```php
RateLimiter::for('api', function (Request $request) {
    $limite = $request->user()?->plan === 'premium' ? 300 : 30;
    return Limit::perMinute($limite)->by($request->user()?->id ?: $request->ip());
});
```

## Exercice 4

```php
// config/cors.php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```
Une requête `fetch()` depuis `http://localhost:3000` (un autre port/domaine)
échoue dans la console du navigateur avec une erreur CORS explicite,
tandis que la même requête depuis `http://localhost:5173` réussit.

## Exercice 5

```markdown
Failles identifiées :

1. `'allowed_origins' => ['*']` combiné à `'supports_credentials' => true` :
   N'IMPORTE QUEL site pourrait effectuer des requêtes authentifiées au nom
   des utilisateurs connectés. Corrigé : lister explicitement les domaines
   de confiance, ex. `['https://mon-frontend.com']`.

2. `APP_DEBUG=true` en production : expose la stack trace complète (chemins
   de fichiers, requêtes SQL, variables d'environnement potentiellement)
   à tout client en cas d'erreur. Corrigé : `APP_DEBUG=false` en production,
   toujours.

3. Route `/login` sans `throttle` : vulnérable à une attaque par force
   brute sur les mots de passe. Corrigé :
   `Route::post('/login', ...)->middleware('throttle:connexion');`
   avec un limiteur strict dédié (ex. 5/minute par IP).

Version corrigée :
```
```php
// config/cors.php
'allowed_origins' => ['https://mon-frontend.com'],
'supports_credentials' => true,
```
```
# .env (production)
APP_DEBUG=false
```
```php
// routes/api.php
Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:connexion');
```
```
