# Solutions — 09.6 Rate Limiting and API Security

## Exercise 1

```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```
```bash
for i in {1..70}; do curl -s -o /dev/null -w "%{http_code}\n" http://localhost:8000/api/annonces; done
# The last ~10 lines show 429 instead of 200
```

## Exercise 2

```php
RateLimiter::for('connexion', fn (Request $request) => Limit::perMinute(5)->by($request->ip()));
```
```php
Route::post('/api/login', [AuthController::class, 'login'])->middleware('throttle:connexion');
```
The 6th, 7th... attempts within the same minute get 429, regardless of
the content sent — even before the login logic itself even runs.

## Exercise 3

```php
RateLimiter::for('api', function (Request $request) {
    $limite = $request->user()?->plan === 'premium' ? 300 : 30;
    return Limit::perMinute($limite)->by($request->user()?->id ?: $request->ip());
});
```

## Exercise 4

```php
// config/cors.php
'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:5173'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```
A `fetch()` request from `http://localhost:3000` (a different port/domain)
fails in the browser console with an explicit CORS error, while the
same request from `http://localhost:5173` succeeds.

## Exercise 5

```markdown
Identified flaws:

1. `'allowed_origins' => ['*']` combined with `'supports_credentials' => true`:
   ANY site could make authenticated requests on behalf of logged-in
   users. Fixed: explicitly list trusted domains, e.g.
   `['https://mon-frontend.com']`.

2. `APP_DEBUG=true` in production: exposes the full stack trace (file
   paths, SQL queries, potentially environment variables) to any client
   on error. Fixed: `APP_DEBUG=false` in production, always.

3. A `/login` route with no `throttle`: vulnerable to a brute-force
   password attack. Fixed:
   `Route::post('/login', ...)->middleware('throttle:connexion');`
   with a strict, dedicated limiter (e.g., 5/minute per IP).

Corrected version:
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
