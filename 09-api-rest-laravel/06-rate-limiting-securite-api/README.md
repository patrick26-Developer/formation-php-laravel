# 09.6 — Rate limiting et sécurité des API

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre l'intérêt du rate limiting (limitation de débit).
- Configurer des limites différenciées par route et par utilisateur.
- Configurer CORS pour une API consommée par un frontend séparé.
- Connaître les bonnes pratiques de sécurité spécifiques aux API.

## 📋 Prérequis

[09.3 — Authentification API avec Sanctum](../03-authentification-api-sanctum/README.md), [02.6 — Sécurité web fondamentale](../../02-php-intermediaire/06-securite-web-fondamentaux/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Le rate limiting : se protéger des abus

Sans limite, un client (volontairement malveillant, ou simplement un bug dans une application tierce) pourrait envoyer des milliers de requêtes par seconde à votre API, la ralentissant pour tout le monde ou provoquant une facture d'infrastructure excessive. Le **rate limiting** plafonne le nombre de requêtes autorisées par client sur une période donnée.

```php
// bootstrap/app.php ou un Service Provider
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

```php
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::apiResource('annonces', AnnonceController::class);
});
```

> 💡 `by($request->user()?->id ?: $request->ip())` limite **par utilisateur authentifié**, ou par **adresse IP** pour un visiteur anonyme — évitant qu'un seul utilisateur authentifié abusif ne soit confondu avec l'ensemble des visiteurs partageant la même IP (par exemple, derrière un même réseau d'entreprise).

### Limites différenciées selon la sensibilité de la route

```php
RateLimiter::for('connexion', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip()); // limite stricte : protège contre le brute-force
});

RateLimiter::for('lecture-publique', function (Request $request) {
    return Limit::perMinute(120)->by($request->ip()); // plus permissif pour de la simple lecture
});
```

```php
Route::post('/api/login', [AuthController::class, 'login'])->middleware('throttle:connexion');
Route::get('/api/annonces', [AnnonceController::class, 'index'])->middleware('throttle:lecture-publique');
```

> ⚠️ Une route de **connexion** doit **toujours** avoir un rate limit strict et dédié — sans lui, un attaquant pourrait essayer des milliers de mots de passe par minute contre un compte (attaque par force brute), rendant `password_hash()`/`password_verify()` (module 02.5) insuffisants seuls pour se protéger.

### La réponse au dépassement de limite

Quand la limite est dépassée, Laravel répond automatiquement :
```
HTTP/1.1 429 Too Many Requests
Retry-After: 45
X-RateLimit-Limit: 60
X-RateLimit-Remaining: 0
```

> 📌 Les en-têtes `X-RateLimit-*` permettent à un client bien conçu (une application mobile, un partenaire) d'anticiper la limite **avant** de la dépasser, plutôt que de la découvrir par un échec brutal.

### CORS : autoriser un frontend séparé à consommer l'API

**CORS** (Cross-Origin Resource Sharing) est un mécanisme du navigateur qui bloque, par défaut, les requêtes JavaScript vers un domaine différent de celui de la page — une protection de sécurité qu'il faut explicitement assouplir pour une API destinée à un frontend sur un autre domaine.

```php
// config/cors.php
'paths' => ['api/*'],
'allowed_origins' => ['https://mon-frontend.com'], // JAMAIS '*' si des identifiants/cookies sont impliqués
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
'supports_credentials' => true, // nécessaire pour Sanctum en mode SPA (module 09.3)
```

> ⚠️ `allowed_origins => ['*']` (autoriser n'importe quel domaine) est une faille de sécurité si combiné avec `supports_credentials => true` : cela permettrait à **n'importe quel site** d'effectuer des requêtes authentifiées au nom de vos utilisateurs. Toujours lister explicitement les domaines de confiance en production.

### Autres bonnes pratiques de sécurité API

- **Toujours HTTPS** en production : un jeton `Bearer` transmis en clair sur HTTP est trivialement interceptable.
- **Ne jamais exposer les traces d'erreur détaillées** (`APP_DEBUG=false` en production, rappel du module 06.1) — une exception non gérée ne doit jamais révéler la structure interne de l'application à un client externe.
- **Valider systématiquement** les entrées, même pour un client "de confiance" (une application mobile peut être décompilée et son API imitée directement).
- **Journaliser les échecs d'authentification répétés**, signal potentiel d'une tentative d'intrusion.

## ✅ Points clés à retenir

- Le rate limiting protège contre les abus ; toujours une limite stricte et dédiée sur les routes de connexion.
- Les en-têtes `X-RateLimit-*` permettent à un client bien conçu d'anticiper la limite.
- CORS doit lister explicitement les domaines de confiance, jamais `*` combiné à `supports_credentials`.
- HTTPS, masquage des erreurs en production, et validation systématique restent non négociables pour une API.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Rate Limiting](https://laravel.com/docs/routing#rate-limiting)
- [laravel.com/docs — CORS](https://laravel.com/docs/routing#cors)
- [OWASP API Security Top 10](https://owasp.org/www-project-api-security/)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [09.5 — Versioning et documentation OpenAPI](../05-versioning-documentation-openapi/README.md) · **Suite :** [Mini-projet : API REST complète](../projet-mini-06-api-rest-complete/README.md)
