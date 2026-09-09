# Exercises — 09.6 Rate Limiting and API Security

## Exercise 1 — First rate limit (easy)

Configure an `api` limiter at 60 requests/minute per user (or IP). Apply it to a route and exceed the limit with repeated requests (`for i in {1..70}; do curl ...; done`) to observe the 429.

## Exercise 2 — Strict login limit (easy)

Configure a `connexion` limiter at 5 attempts/minute per IP. Apply it to `/api/login`. Test 6 consecutive failed login attempts.

## Exercise 3 — Limits differentiated by plan (medium)

Simulate two user "plans" (`gratuit`, `premium` — a column on `User`). Configure a limiter returning 30/minute for `gratuit` and 300/minute for `premium`, based on `$request->user()->plan`.

## Exercise 4 — Configuring CORS (medium)

Configure `config/cors.php` to allow only one specific domain (`http://localhost:5173`, a typical Vite frontend). Verify with the browser's developer tools that a request from another domain is correctly blocked.

## Exercise 5 — API security audit (hard)

This configuration contains several flaws. Identify them all and fix them:
```php
// config/cors.php
'allowed_origins' => ['*'],
'supports_credentials' => true,

// .env
APP_DEBUG=true   // in production

// routes/api.php
Route::post('/login', [AuthController::class, 'login']); // no throttle
```

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
