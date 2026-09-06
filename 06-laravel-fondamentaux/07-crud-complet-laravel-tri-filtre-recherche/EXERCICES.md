# Exercices — 06.7 CRUD complet Laravel

## Exercice 1 — CRUD de base (facile)

Générez un Resource Controller complet pour un modèle `Article` (`titre`, `contenu`). Implémentez les 7 méthodes avec Eloquent, sans tri/filtre pour l'instant.

## Exercice 2 — Recherche (facile)

Ajoutez une recherche par titre dans `index()`, avec un champ de formulaire GET et `when()`.

## Exercice 3 — Tri cliquable (moyen)

Ajoutez un tri sur `titre` et `created_at`, avec liste blanche de colonnes autorisées, et des liens cliquables dans la vue qui inversent l'ordre au second clic.

## Exercice 4 — Pagination avec filtres préservés (moyen)

Ajoutez `paginate(10)` et `withQueryString()`. Vérifiez que changer de page préserve bien la recherche et le tri actifs dans l'URL.

## Exercice 5 — Filtre combiné avec statut (difficile)

Ajoutez une colonne `publie` (boolean) à `Article`. Ajoutez un filtre par statut (`tous`/`publies`/`brouillons`) combiné avec la recherche et le tri existants, tous appliqués simultanément si présents. Vérifiez chaque combinaison possible.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
