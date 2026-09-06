# Exercices — 07.1 Relations Eloquent avancées

## Exercice 1 — belongsToMany (facile)

Ajoutez un modèle `Tag` et une relation N-N avec `Article` du [mini-projet du niveau 06](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.md). Créez la migration de la table pivot, associez des tags à un article via `attach()`, affichez-les.

## Exercice 2 — sync() (facile)

Créez un formulaire de modification d'article avec des cases à cocher pour les tags. Dans le contrôleur, utilisez `sync($request->input('tags', []))` pour mettre à jour les associations en une seule opération.

## Exercice 3 — Relation polymorphique (moyen)

Créez un modèle `Like` polymorphique (`likeable`), utilisable sur `Article` **et** `Comment`. Implémentez la relation dans les deux sens et affichez le nombre de likes d'un article et d'un commentaire.

## Exercice 4 — Détecter et corriger un N+1 (moyen)

Écrivez volontairement une vue affichant 20 articles avec leur catégorie SANS eager loading. Utilisez `DB::listen()` (ou la Laravel Debugbar) pour compter les requêtes exécutées. Ajoutez `with('categorie')` et comparez le nombre de requêtes avant/après.

## Exercice 5 — Table pivot enrichie (difficile)

Ajoutez une colonne `ordre` (integer) à la table pivot `article_tag`. Utilisez `withPivot('ordre')` et affichez les tags d'un article triés par cette colonne (`$article->tags->sortBy('pivot.ordre')`).

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
