# Exercices — 09.2 API Resources et transformation des données

## Exercice 1 — Première Resource (facile)

Créez `ProduitResource` exposant `id`, `nom`, `prix` (casté en float). Utilisez-la dans `show()` et comparez la réponse avec un retour direct du modèle.

## Exercice 2 — Masquer un champ sensible (facile)

Ajoutez un champ `cout_achat` au modèle (non destiné aux clients de l'API). Vérifiez qu'il n'apparaît PAS dans `ProduitResource::toArray()` même s'il existe en base.

## Exercice 3 — Relation avec whenLoaded (moyen)

Ajoutez la catégorie à `ProduitResource` avec `whenLoaded()`. Testez `show()` avec et sans `->load('categorie')` en amont, observez la différence (champ absent vs présent dans le JSON).

## Exercice 4 — Resource Collection avec pagination (moyen)

Utilisez `ProduitResource::collection(Produit::paginate(10))` dans `index()`. Inspectez la réponse JSON complète et identifiez les clés `data`, `links`, `meta`.

## Exercice 5 — Détecter un N+1 dans une Resource (difficile)

Écrivez volontairement `'categorie_nom' => $this->categorie->nom` (SANS `whenLoaded`) dans une Resource utilisée par une collection de 20 produits SANS eager loading en amont. Utilisez `DB::listen()` (module 07.1) pour compter les requêtes. Corrigez avec `with('categorie')` + `whenLoaded()` et comparez.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
