# Exercises — 09.4 OAuth2 with Passport

## Exercise 1 — Installing Passport (easy)

Install Passport on a Laravel project. Run `passport:install` and note the generated client credentials.

## Exercise 2 — Client Credentials (easy)

Create a route protected by `middleware('client')` returning a public global statistic. Get a token via the Client Credentials grant (`curl -X POST /oauth/token -d 'grant_type=client_credentials&client_id=...&client_secret=...'`) and test access.

## Exercise 3 — Choosing Sanctum or Passport (medium)

For each of the following cases, state Sanctum or Passport and justify in one sentence: (a) your platform's official mobile app, (b) an external partner that wants to read a user's listings with their consent, (c) an internal script that syncs data overnight, (d) a React SPA of the same product on the same domain.

## Exercise 4 — Passport scopes (medium)

Define two scopes (`annonces:lire`, `annonces:ecrire`) in `AuthServiceProvider`. Protect a route with `scope:annonces:ecrire` and verify a token without this scope is rejected.

## Exercise 5 — Diagram the Authorization Code flow (hard)

Draw (in ASCII, or as a structured text description in a `FLUX.md` file) the 4 steps of the Authorization Code grant applied to a concrete case: a partner "ComparateurAnnonces.com" wants to display a user's listings with their consent. Identify at each step who sends what to whom.

---

See [solutions/README.md](solutions/README.md) for the answer key.
