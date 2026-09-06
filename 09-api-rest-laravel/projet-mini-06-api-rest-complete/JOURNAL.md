# Journal de construction

## Étape 1 — Ne rien dupliquer : réutiliser le domaine du niveau 07

Décision structurante de ce projet : `Annonce`, `Category`, `Message`, `AnnoncePolicy`, `StoreAnnonceRequest`, `UpdateAnnonceRequest` proviennent **tels quels** du [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md), sans une seule ligne modifiée. Seule une nouvelle **couche de présentation** (contrôleurs API, Resources, routes) est ajoutée par-dessus — la preuve concrète que séparer logique métier et présentation (déjà pratiqué au [grand projet du niveau 03](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.md)) permet d'exposer la même substance sous plusieurs formes sans duplication.

## Étape 2 — Les Resources, miroir des vues Blade du niveau 07

`AnnonceResource` expose exactement les mêmes informations que `articles/show.blade.php` (module 06) et `annonces/show.blade.php` (module 07) affichaient en HTML — mais en JSON structuré, avec `whenLoaded('categorie')` et `whenLoaded('user')` pour ne jamais provoquer de N+1 sur la liste paginée (module 09.2).

## Étape 3 — Sanctum, pas Passport

Conformément à la règle pratique du [module 09.4](../04-authentification-api-passport-oauth2/README.md) : cette API sert **votre propre** client (une future app mobile officielle), pas des applications tierces développées par d'autres équipes. Sanctum suffit largement et évite la complexité d'un serveur OAuth2 complet.

## Étape 4 — Trois limiteurs, trois sensibilités

`AppServiceProvider::boot()` définit trois `RateLimiter::for()` distincts : `connexion` (5/min/IP, strict contre le brute-force), `lecture-publique` (120/min/IP, permissif car sans authentification et peu coûteux), `api` (60/min/utilisateur, le défaut pour les routes authentifiées). Cette différenciation reflète directement le tableau du [module 09.6](../06-rate-limiting-securite-api/README.md) : une seule limite globale aurait été soit trop stricte pour la lecture, soit trop permissive pour la connexion.

## Étape 5 — Les tests, centrés sur la sécurité de l'API

`AnnonceApiTest` inclut délibérément un test vérifiant qu'un utilisateur ne peut pas supprimer l'annonce d'un autre **via l'API** — la même garantie que la Policy offre côté web, mais vérifiée indépendamment ici, car une nouvelle surface d'entrée (l'API) est un nouveau chemin potentiel pour contourner une règle métier si elle n'est pas correctement branchée. Le test confirme que `AnnoncePolicy::delete()` s'applique bien identiquement, sans réécriture.

## Pour aller plus loin (hors scope de ce mini-projet)

Aucun versioning v2 n'est implémenté (le sujet est traité en exercice au module 09.5), et la documentation OpenAPI reste partielle (quelques endpoints annotés en exemple, pas la totalité) — à compléter en exercice.
