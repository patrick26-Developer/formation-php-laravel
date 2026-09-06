# Exercices — 03.4 Construction d'une API REST en PHP natif

## Exercice 1 — Helpers de réponse JSON (facile)

Créez un fichier `helpers.php` avec les fonctions `repondreJson()` et `lireCorpsJson()` du cours. Écrivez un script `test.php` qui répond `{"message": "API opérationnelle"}` avec le code 200.

## Exercice 2 — Endpoint de création (facile)

Simulez un tableau PHP en mémoire (`$taches = [];`) comme "base de données". Créez un endpoint qui lit un corps JSON `{"titre": "..."}`, valide que `titre` est présent (sinon 400), ajoute la tâche au tableau avec un ID auto-incrémenté, et répond 201 avec la tâche créée.

## Exercice 3 — Endpoint de liste avec codes de statut (moyen)

Créez un endpoint qui répond la liste complète des tâches en 200, mais si le tableau est vide, répond quand même 200 avec un tableau vide (pas une erreur — une liste vide est un résultat **valide**, pas une erreur).

## Exercice 4 — Endpoint avec gestion d'erreurs complète (moyen)

Créez un endpoint `GET /taches/{id}` (simulez `$id` via `$_GET['id']`) qui répond 404 si l'ID n'existe pas dans le tableau, et 200 avec la tâche sinon. Ajoutez un endpoint `DELETE` simulé (vérifiez `$_SERVER['REQUEST_METHOD']`) qui répond 204 sans contenu si la suppression réussit, 404 sinon.

## Exercice 5 — Mini-API CRUD complète (difficile)

Assemblez tous les exercices précédents en une seule mini-API avec un simple routeur (réutilisez celui du [module 03.2](../02-architecture-mvc-from-scratch/README.md)) gérant : `GET /api/taches`, `POST /api/taches`, `GET /api/taches/{id}`, `DELETE /api/taches/{id}`. Testez chaque endpoint avec `curl` (exemples de commandes à inclure en commentaire).

---

Comparez avec [solutions/](solutions/) une fois terminé.
