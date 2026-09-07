# Exercices — 10.2 Composants réactifs et formulaires

## Exercice 1 — Formulaire simple (facile)

Créez un composant `FormulaireCategorie` avec un champ `nom` (`wire:model`), une méthode `creer()` qui l'ajoute en base et vide le champ.

## Exercice 2 — Validation avec attribut Rule (facile)

Ajoutez `#[Rule('required|min:2|max:50')]` sur `$nom`. Affichez l'erreur avec `@error`. Testez une soumission vide.

## Exercice 3 — Validation en temps réel (moyen)

Passez `wire:model.live` sur le champ et ajoutez `updated()` avec `validateOnly()`. Vérifiez que l'erreur apparaît/disparaît au fur et à mesure de la saisie, sans soumettre le formulaire.

## Exercice 4 — Communication entre composants (moyen)

Créez `ListeCategories` qui affiche toutes les catégories. Faites en sorte que `FormulaireCategorie::creer()` émette un événement `categorie-creee`, écouté par `ListeCategories` pour se rafraîchir automatiquement, sans recharger la page.

## Exercice 5 — Comparer .live et déferred (difficile)

Créez un champ de recherche avec `wire:model` (déferred, sans `.live`) relié à un bouton "Rechercher" (`wire:click`), puis une seconde version avec `wire:model.live` sans bouton (recherche à chaque frappe). Avec les outils réseau du navigateur, comptez le nombre de requêtes AJAX pour taper "laravel" (7 caractères) dans chaque version. Expliquez en commentaire le compromis UX/performance observé.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
