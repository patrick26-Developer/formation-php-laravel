# Exercices — 09.4 OAuth2 avec Passport

## Exercice 1 — Installer Passport (facile)

Installez Passport sur un projet Laravel. Exécutez `passport:install` et notez les identifiants client générés.

## Exercice 2 — Client Credentials (facile)

Créez une route protégée par `middleware('client')` retournant une statistique publique globale. Obtenez un jeton via le grant Client Credentials (`curl -X POST /oauth/token -d 'grant_type=client_credentials&client_id=...&client_secret=...'`) et testez l'accès.

## Exercice 3 — Choisir Sanctum ou Passport (moyen)

Pour chacun des cas suivants, indiquez Sanctum ou Passport et justifiez en une phrase : (a) l'app mobile officielle de votre plateforme, (b) un partenaire externe qui veut lire les annonces d'un utilisateur avec son consentement, (c) un script interne qui synchronise des données la nuit, (d) une SPA React du même produit sur le même domaine.

## Exercice 4 — Scopes Passport (moyen)

Définissez deux scopes (`annonces:lire`, `annonces:ecrire`) dans `AuthServiceProvider`. Protégez une route avec `scope:annonces:ecrire` et vérifiez qu'un jeton sans ce scope est refusé.

## Exercice 5 — Schéma du flux Authorization Code (difficile)

Dessinez (en ASCII ou en description textuelle structurée dans un fichier `FLUX.md`) les 4 étapes du grant Authorization Code appliqué à un cas concret : un partenaire "ComparateurAnnonces.com" veut afficher les annonces d'un utilisateur avec son consentement. Identifiez à chaque étape qui envoie quoi à qui.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
