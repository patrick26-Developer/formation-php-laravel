# Exercices — 10.4 Tables dynamiques Livewire

## Exercice 1 — Table avec recherche (facile)

Créez `ProduitsTable` avec recherche par nom (`wire:model.live.debounce.300ms`), sans tri ni filtre pour l'instant.

## Exercice 2 — Ajouter le tri cliquable (facile)

Ajoutez `trierPar()` avec liste blanche de colonnes, et affichez une flèche indiquant la colonne/l'ordre actifs dans les en-têtes.

## Exercice 3 — Filtre par catégorie + pagination (moyen)

Ajoutez un `<select>` de catégorie et `WithPagination`. Vérifiez que changer de page préserve la recherche et le filtre actifs (grâce à `#[Url]`).

## Exercice 4 — Réinitialiser la pagination au bon moment (moyen)

Ajoutez `updatingRecherche()` et `updatingCategorieId()` pour réinitialiser la page à 1 dès qu'un filtre change. Sans ce hook, provoquez volontairement le bug (filtrer depuis la page 3 d'une longue liste) et observez le problème avant correction.

## Exercice 5 — Partager un état de filtre via URL (difficile)

Avec `#[Url]` en place, copiez l'URL de la table après avoir tapé une recherche et sélectionné un tri. Ouvrez cette URL dans un nouvel onglet (ou partagez-la) : vérifiez que l'état exact (recherche, tri, page) est restauré sans aucune action supplémentaire. Expliquez en commentaire pourquoi c'est un avantage significatif par rapport à un composant Livewire qui ne synchroniserait pas son état avec l'URL.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
