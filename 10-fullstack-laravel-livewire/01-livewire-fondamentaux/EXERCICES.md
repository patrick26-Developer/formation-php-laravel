# Exercices — 10.1 Livewire : les fondamentaux

## Exercice 1 — Premier compteur (facile)

Créez le composant `Compteur` du cours. Ajoutez un bouton "-1" et un bouton "Réinitialiser" (remet `total` à 0).

## Exercice 2 — Propriété initialisée via mount() (facile)

Modifiez `Compteur` pour accepter une valeur initiale via `mount(int $valeurInitiale = 0)`. Affichez deux compteurs sur la même page avec des valeurs initiales différentes (`<livewire:compteur :valeur-initiale="5" />` et `10`).

## Exercice 3 — Basculer un état booléen (moyen)

Créez un composant `Interrupteur` avec une propriété `$actif` (bool) et une méthode `basculer()` qui l'inverse. Affichez "Allumé"/"Éteint" selon l'état, avec un style visuel différent (couleur de fond).

## Exercice 4 — Plusieurs instances indépendantes (moyen)

Placez trois `<livewire:interrupteur />` sur la même page. Vérifiez que cliquer sur l'un n'affecte pas les autres — chaque instance a son propre état côté serveur.

## Exercice 5 — Cycle de vie complet (difficile)

Ajoutez à `Compteur` une méthode `mount()` qui journalise (`logger()`) "Composant monté avec la valeur X", une méthode `updated($nom, $valeur)` (hook automatique Livewire, appelé après CHAQUE changement de propriété publique) qui journalise chaque changement. Observez les logs après plusieurs clics et expliquez en commentaire pourquoi `updated()` ne se déclenche PAS pour la première valeur définie par `mount()`.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
