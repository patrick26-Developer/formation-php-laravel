# Exercices — 06.6 Validation des formulaires

## Exercice 1 — Validation de base (facile)

Ajoutez une validation à un contrôleur `store()` pour un modèle `Produit` : `nom` requis (max 150), `prix` requis numérique positif (`min:0`), `stock` requis entier positif.

## Exercice 2 — Messages personnalisés (facile)

Personnalisez les messages d'erreur du formulaire de l'exercice 1 en français explicite pour chaque règle.

## Exercice 3 — Unicité et existence (moyen)

Ajoutez à un formulaire d'inscription : `email` requis, format email, unique dans `users`. Ajoutez à un formulaire de produit : `categorie_id` requis, doit exister dans `categories`.

## Exercice 4 — Form Request (moyen)

Extrayez la validation de l'exercice 1 dans une classe `StoreProduitRequest`. Adaptez le contrôleur pour l'utiliser à la place de `$request->validate()`.

## Exercice 5 — Form Request partagé création/modification (difficile)

Créez `StoreProduitRequest` et `UpdateProduitRequest` séparés, où la règle `unique` sur un champ (par exemple un code produit unique) doit **ignorer** l'enregistrement courant lors d'une modification (indice : `Rule::unique('produits')->ignore($this->produit)`). Expliquez en commentaire pourquoi cette règle diffère entre création et modification.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
