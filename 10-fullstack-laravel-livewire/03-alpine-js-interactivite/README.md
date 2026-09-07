# 10.3 — Alpine.js pour l'interactivité légère

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre quand utiliser Alpine.js plutôt que Livewire.
- Utiliser `x-data`, `x-show`, `x-on` pour de l'interactivité purement client.
- Combiner Alpine.js et Livewire dans un même composant.

## 📋 Prérequis

[10.2 — Composants réactifs et formulaires](../02-composants-reactifs-formulaires/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Pourquoi Alpine.js en complément de Livewire ?

Chaque interaction Livewire déclenche une requête réseau vers le serveur (module 10.1). Pour des interactions **purement visuelles**, sans besoin de données serveur (ouvrir/fermer un menu déroulant, afficher/masquer un mot de passe, un onglet actif) — faire un aller-retour réseau serait un gaspillage inutile. **Alpine.js** gère ces interactions **entièrement côté navigateur**, en JavaScript minimal, directement dans les attributs HTML.

> 💡 Alpine.js est inclus **automatiquement** avec Livewire (depuis Livewire 3) : aucune installation séparée n'est nécessaire dans un projet qui utilise déjà Livewire.

### `x-data` et `x-show` : état purement local au navigateur

```blade
<div x-data="{ ouvert: false }">
    <button x-on:click="ouvert = !ouvert">Afficher les détails</button>

    <div x-show="ouvert">
        Contenu affiché/masqué instantanément, sans requête serveur.
    </div>
</div>
```

> 📌 `x-data="{ ouvert: false }"` déclare une variable JavaScript locale à ce bloc HTML. `x-on:click` (raccourci `@click`) réagit à un événement DOM. Aucune de ces interactions n'atteint jamais le serveur Laravel.

### `x-model` : lier un champ à une variable Alpine (comparaison avec Livewire)

```blade
<div x-data="{ recherche: '' }">
    <input type="text" x-model="recherche">
    <p x-show="recherche.length > 0">Vous cherchez : <span x-text="recherche"></span></p>
</div>
```

> ⚠️ Ce code Alpine reste **entièrement côté client** : il ne peut pas interroger la base de données. Pour une vraie recherche filtrant des résultats serveur, il faut Livewire (`wire:model`, module 10.4) ou du JavaScript appelant une API (niveau 09) — Alpine seul ne suffit que pour de l'état d'interface pure.

### Combiner Alpine.js et Livewire dans un même composant

```blade
<div x-data="{ menuOuvert: false }">
    <button @click="menuOuvert = !menuOuvert">Actions</button>

    <div x-show="menuOuvert">
        {{-- Ce bouton, lui, déclenche bien une requête serveur --}}
        <button wire:click="archiverAnnonce">Archiver</button>
    </div>
</div>
```

> 💡 Ce mélange est très courant en pratique : Alpine gère "le menu est-il ouvert visuellement ?" (jamais besoin du serveur pour le savoir), Livewire gère "que se passe-t-il quand on clique sur Archiver ?" (nécessite le serveur, car cela modifie une donnée en base).

### `$wire` : accéder à Livewire depuis Alpine

```blade
<div x-data>
    <button @click="$wire.incrementer()">Incrémenter via Alpine</button>
    <span x-text="$wire.total"></span>
</div>
```

> 📌 `$wire` expose les propriétés et méthodes du composant Livewire parent directement à Alpine — utile pour des interactions hybrides fines (par exemple, une confirmation JavaScript avant d'appeler une méthode Livewire).

## ✅ Points clés à retenir

- Alpine.js gère l'interactivité purement visuelle (menus, onglets, affichage conditionnel) sans jamais solliciter le serveur.
- Alpine est inclus automatiquement avec Livewire 3, sans installation séparée.
- `x-data`/`x-show`/`x-on`/`x-model` restent entièrement côté client : aucun accès direct à la base de données.
- `$wire` permet à Alpine d'appeler des méthodes ou lire des propriétés du composant Livewire parent.

## ➡️ Pour aller plus loin

- [alpinejs.dev](https://alpinejs.dev/)
- [livewire.laravel.com/docs/alpine](https://livewire.laravel.com/docs/alpine)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [10.2 — Composants réactifs et formulaires](../02-composants-reactifs-formulaires/README.md) · **Suite :** [10.4 — Tables dynamiques : tri, filtre, recherche](../04-tables-dynamiques-tri-filtre-recherche/README.md)
