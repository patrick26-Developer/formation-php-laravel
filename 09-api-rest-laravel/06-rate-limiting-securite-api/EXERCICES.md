# Exercices — 09.6 Rate limiting et sécurité des API

## Exercice 1 — Premier rate limit (facile)

Configurez un limiteur `api` à 60 requêtes/minute par utilisateur (ou IP). Appliquez-le à une route et dépassez la limite avec des requêtes répétées (`for i in {1..70}; do curl ...; done`) pour observer le 429.

## Exercice 2 — Limite stricte sur la connexion (facile)

Configurez un limiteur `connexion` à 5 tentatives/minute par IP. Appliquez-le à `/api/login`. Testez 6 tentatives de connexion échouées consécutives.

## Exercice 3 — Limites différenciées par plan (moyen)

Simulez deux "plans" utilisateur (`gratuit`, `premium` — colonne sur `User`). Configurez un limiteur retournant 30/minute pour `gratuit` et 300/minute pour `premium`, basé sur `$request->user()->plan`.

## Exercice 4 — Configurer CORS (moyen)

Configurez `config/cors.php` pour n'autoriser qu'un domaine précis (`http://localhost:5173`, un frontend Vite typique). Vérifiez avec les outils de développement du navigateur qu'une requête depuis un autre domaine est bien bloquée.

## Exercice 5 — Audit de sécurité API (difficile)

Cette configuration contient plusieurs failles. Identifiez-les toutes et corrigez :
```php
// config/cors.php
'allowed_origins' => ['*'],
'supports_credentials' => true,

// .env
APP_DEBUG=true   // en production

// routes/api.php
Route::post('/login', [AuthController::class, 'login']); // pas de throttle
```

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
