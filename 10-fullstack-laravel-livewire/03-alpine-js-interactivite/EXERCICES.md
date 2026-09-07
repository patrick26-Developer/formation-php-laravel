# Exercices — 10.3 Alpine.js pour l'interactivité légère

## Exercice 1 — Menu déroulant (facile)

Créez un menu déroulant purement Alpine (`x-data`, `x-show`, `@click`), sans aucun composant Livewire.

## Exercice 2 — Onglets (facile)

Créez un système d'onglets Alpine (`x-data="{ onglet: 'infos' }"`, plusieurs boutons qui changent `onglet`, plusieurs blocs `x-show="onglet === '...'"`).

## Exercice 3 — Afficher/masquer un mot de passe (moyen)

Créez un champ mot de passe avec un bouton "œil" qui bascule entre `type="password"` et `type="text"` via Alpine (`x-data="{ visible: false }"`, `:type="visible ? 'text' : 'password'"`).

## Exercice 4 — Alpine + Livewire combinés (moyen)

Reprenez le composant `Interrupteur` du [module 10.1](../01-livewire-fondamentaux/README.md). Ajoutez une confirmation Alpine (`x-data`, une boîte de dialogue simple) avant d'appeler `wire:click="basculer"`, uniquement quand on éteint (pas quand on allume).

## Exercice 5 — $wire pour un compteur hybride (difficile)

Créez un composant Livewire avec une propriété `total`. Depuis un bloc Alpine séparé dans la même vue, affichez `$wire.total` en temps réel (`x-text="$wire.total"`) et ajoutez un bouton Alpine qui appelle `$wire.incrementer()`. Expliquez en commentaire pourquoi ce bouton déclenche malgré tout une requête serveur, contrairement aux exercices précédents.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
