# Exercises — 09.3 API Authentication with Sanctum

## Exercise 1 — Installing Sanctum (easy)

Install Sanctum on a Laravel project with Breeze. Create the lesson's `/api/login` endpoint. Test with `curl`: get a token.

## Exercise 2 — Protecting a route (easy)

Protect `GET /api/annonces` with `auth:sanctum`. Test with no token (401 expected) then with the token obtained in exercise 1 (200 expected).

## Exercise 3 — Logging out (medium)

Implement `/api/logout`. Verify that after logging out, a request with the old token returns 401.

## Exercise 4 — Abilities (medium)

Create two tokens for the same user: one with `['annonces:lire']`, one with `['annonces:lire', 'annonces:ecrire']`. Protect `POST /api/annonces` with `ability:annonces:ecrire` and verify only the second token has access.

## Exercise 5 — Listing and revoking active tokens (hard)

Create an endpoint `GET /api/jetons` returning the list of the user's active tokens (`$request->user()->tokens`, without exposing the token's value itself, only `name` and `created_at`). Create `DELETE /api/jetons/{id}` allowing a specific token to be revoked. Verify a user can only revoke THEIR OWN tokens.

---

See [solutions/README.md](solutions/README.md) for the answer key.
