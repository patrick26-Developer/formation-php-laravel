# Mini-projet : Dashboard admin Livewire

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Construire un back-office de modération pour la plateforme d'annonces (niveaux 07-09) : table réactive avec recherche/tri/filtre/pagination, actions instantanées (activer/désactiver/supprimer), et un widget de statistiques qui se met à jour en temps réel — **sans écrire une seule ligne de JavaScript**, et sans API séparée.

## 📋 Modules mobilisés

- [10.1 — Livewire : les fondamentaux](../01-livewire-fondamentaux/README.md)
- [10.2 — Composants réactifs et formulaires](../02-composants-reactifs-formulaires/README.md) (communication par événements entre `AnnoncesTable` et `StatistiquesWidget`)
- [10.3 — Alpine.js](../03-alpine-js-interactivite/README.md) (confirmation de suppression, purement côté client)
- [10.4 — Tables dynamiques](../04-tables-dynamiques-tri-filtre-recherche/README.md) (recherche debounced, tri, filtre, `#[Url]`, pagination)

## 🧠 Ce que vous allez apprendre

- Faire communiquer deux composants Livewire indépendants (`AnnoncesTable` → événement → `StatistiquesWidget`) sans qu'aucun des deux ne connaisse l'existence de l'autre directement.
- Combiner Alpine.js (confirmation immédiate, sans requête serveur) et Livewire (l'action réelle, avec requête serveur) sur un même bouton.
- Réutiliser le modèle `Annonce` et ses scopes (`actives()`, `deLaCategorie()`) du niveau 07/08 sans aucune modification, une nouvelle fois.
- Tester des composants Livewire avec Pest (`Livewire::test()`), y compris leurs interactions (`set()`, `call()`, `assertSee()`).

## 📂 Structure du projet

Fichiers à ajouter par-dessus le [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) :

```
projet-mini-07-dashboard-admin-livewire/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/migrations/    # ajoute users.est_admin
├── app/Livewire/Admin/
│   ├── AnnoncesTable.php        # recherche, tri, filtre, pagination, actions
│   └── StatistiquesWidget.php     # écoute les changements, se recalcule
├── resources/views/
│   ├── admin/dashboard.blade.php
│   └── livewire/admin/
│       ├── annonces-table.blade.php
│       └── statistiques-widget.blade.php
├── routes/web.php
└── tests/Feature/AnnoncesTableTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md) — installer Livewire, copier ces fichiers, créer un compte admin.
2. [EXECUTION.md](EXECUTION.md) — utiliser le dashboard, observer la réactivité sans rechargement de page.
3. **Avant de lire le code fourni**, essayez de construire vous-même la communication par événement entre les deux composants, à partir du module 10.2.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Niveau 11 — DevOps avancé](../../11-devops-docker-cicd-avance/README.md)
