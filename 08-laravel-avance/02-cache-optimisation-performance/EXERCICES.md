# Exercices — 08.2 Cache et optimisation de performance

## Exercice 1 — Premier cache (facile)

Mettez en cache la liste des catégories du [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) pendant 1 heure avec `Cache::remember()`. Vérifiez avec `DB::listen()` (module 07.1) qu'une seule requête SQL est exécutée sur plusieurs chargements successifs de la page.

## Exercice 2 — Invalidation manuelle (facile)

Ajoutez `Cache::forget('categories.toutes')` dans `CategoryController::store()` après création. Vérifiez qu'une nouvelle catégorie apparaît immédiatement dans la liste mise en cache.

## Exercice 3 — Invalidation via Model Event (moyen)

Remplacez l'invalidation manuelle de l'exercice 2 par un Model Event (`saved`/`deleted`) sur `Category`, garantissant l'invalidation peu importe le point d'entrée de la modification.

## Exercice 4 — Cache paramétré par utilisateur (moyen)

Mettez en cache le nombre d'annonces actives d'un utilisateur (`"annonces.actives.count.{id}"`, 15 minutes). Vérifiez que deux utilisateurs différents obtiennent bien des valeurs indépendantes.

## Exercice 5 — Mesurer le gain réel (difficile)

Avec une catégorie ayant 100+ annonces (générez-les via factory), comparez le temps de réponse de la page liste **sans** cache puis **avec** cache actif (`microtime(true)` avant/après, ou la Laravel Debugbar). Documentez le gain mesuré et expliquez en commentaire pourquoi ce gain serait quasi nul sur une page qui change à chaque requête (ex : un fil d'actualité en temps réel).

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
