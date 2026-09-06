# Exercices — 09.3 Authentification API avec Sanctum

## Exercice 1 — Installer Sanctum (facile)

Installez Sanctum sur un projet Laravel avec Breeze. Créez l'endpoint `/api/login` du cours. Testez avec `curl` : obtenez un jeton.

## Exercice 2 — Protéger une route (facile)

Protégez `GET /api/annonces` avec `auth:sanctum`. Testez sans jeton (401 attendu) puis avec le jeton obtenu à l'exercice 1 (200 attendu).

## Exercice 3 — Déconnexion (moyen)

Implémentez `/api/logout`. Vérifiez qu'après déconnexion, une requête avec l'ancien jeton retourne 401.

## Exercice 4 — Abilities (moyen)

Créez deux jetons pour un même utilisateur : un avec `['annonces:lire']`, un avec `['annonces:lire', 'annonces:ecrire']`. Protégez `POST /api/annonces` avec `ability:annonces:ecrire` et vérifiez que seul le second jeton y a accès.

## Exercice 5 — Lister et révoquer les jetons actifs (difficile)

Créez un endpoint `GET /api/jetons` retournant la liste des jetons actifs de l'utilisateur (`$request->user()->tokens`, sans exposer la valeur du jeton lui-même, seulement `name` et `created_at`). Créez `DELETE /api/jetons/{id}` permettant de révoquer un jeton précis. Vérifiez qu'un utilisateur ne peut révoquer que SES PROPRES jetons.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
