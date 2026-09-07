# Journal de construction

## Étape 1 — Réutiliser, encore : aucun nouveau modèle

Comme le mini-projet du niveau 09, ce dashboard n'introduit **aucun** nouveau modèle Eloquent : `Annonce`, `Category`, et leurs scopes (`actives()`, `deLaCategorie()`) proviennent tels quels du niveau 07. Seule une colonne `est_admin` est ajoutée à `users`, via une migration additive — jamais en modifiant une migration existante (rappel du module 06.5).

## Étape 2 — `AnnoncesTable`, synthèse du module 10.4

Ce composant est une transposition directe de l'exemple du [module 10.4](../04-tables-dynamiques-tri-filtre-recherche/README.md) : mêmes `#[Url]`, même liste blanche de colonnes triables, même hook `updatingRecherche()`. La seule nouveauté propre à ce projet : les méthodes `basculerStatut()` et `supprimer()`, qui modifient une annonce puis appellent `$this->dispatch('statistiques-modifiees')`.

## Étape 3 — `StatistiquesWidget`, découplé par construction

Ce composant n'a **aucune référence** à `AnnoncesTable` dans son code : il écoute simplement un événement nommé (`#[On('statistiques-modifiees')]`). Cette décision permet d'ajouter, demain, une troisième source d'événements (par exemple une action en masse depuis une autre page) sans jamais modifier `StatistiquesWidget` — le même bénéfice de découplage que les Events/Listeners du [module 08.1](../../08-laravel-avance/01-jobs-queues-events-listeners/README.md), appliqué ici à la communication entre composants d'interface plutôt qu'entre classes métier.

## Étape 4 — Alpine pour la confirmation, jamais pour la donnée

Le bouton "Supprimer" combine `x-on:click` (Alpine, purement client : `confirm()` est une fonction JavaScript native du navigateur, aucun aller-retour serveur) et `$wire.supprimer(...)` (Livewire, qui exécute réellement la suppression en base). Cette séparation nette suit directement la règle du [module 10.3](../03-alpine-js-interactivite/README.md) : Alpine gère "l'utilisateur a-t-il confirmé visuellement ?", Livewire gère "la donnée doit-elle réellement changer ?".

## Étape 5 — Tester un composant Livewire comme n'importe quel code Laravel

`AnnoncesTableTest` utilise `Livewire::test()` (module 10.4, complété par le plugin Pest dédié) pour piloter le composant exactement comme un utilisateur le ferait : `set('recherche', ...)`, `call('basculerStatut', ...)`, puis des assertions sur le HTML rendu ou l'état de la base. Le test sur la réinitialisation de pagination (`updatingRecherche()`) prouve un comportement qui, sans lui, serait un bug facilement introduit par erreur lors d'une future modification du composant.

## Pour aller plus loin (hors scope de ce mini-projet)

Aucune action en masse (sélectionner plusieurs annonces pour les désactiver d'un coup) n'est implémentée, et le Gate `acceder-admin` reste minimal (un simple booléen, pas un système de rôles complet) — approfondi par le concept de Policies à rôles multiples déjà vu au module 07.5, à étendre en exercice.
