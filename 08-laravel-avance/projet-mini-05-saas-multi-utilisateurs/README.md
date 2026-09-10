# Mini-projet : SaaS multi-utilisateurs

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Construire un SaaS de gestion de projets **multi-tenant** : chaque organisation (tenant) ne voit que ses propres données, avec traitement en arrière-plan, cache, injection de dépendances via interface, et une suite de tests Pest couvrant spécifiquement l'isolation entre tenants — le risque de sécurité le plus critique de ce type d'architecture.

## 📋 Modules mobilisés

- [08.1 — Jobs, Queues, Events, Listeners](../01-jobs-queues-events-listeners/README.md) (`GenererRapportHebdomadaire`)
- [08.2 — Cache et optimisation](../02-cache-optimisation-performance/README.md) (statistiques du tableau de bord, cache paramétré par tenant)
- [08.3 — Tests avec Pest](../03-tests-pest-phpunit-laravel/README.md) (`Queue::fake()`, tests d'isolation)
- [08.4 — Service Providers et packages](../04-packages-service-providers-personnalises/README.md) (`RapportGenerator` lié à `RapportHebdomadaireGenerator`)
- [08.5 — Architecture modulaire et multi-tenancy](../05-architecture-modulaire/README.md) (scope global `tenant_id`)

## 🧠 Ce que vous allez apprendre

- Implémenter la stratégie de multi-tenancy par colonne (`tenant_id`) avec un scope global Eloquent, **et** écrire les tests qui prouvent concrètement l'isolation entre deux organisations.
- Faire cohabiter scope global (protection automatique) et Policy (seconde ligne de défense explicite) sur le même modèle.
- Injecter une interface (`RapportGenerator`) dans un Job traité en arrière-plan, exactement comme dans un contrôleur.
- Mettre en cache des statistiques **par tenant**, avec invalidation au bon moment.

## 📂 Structure du projet

Fichiers à ajouter à un projet Laravel avec Breeze installé :

```
projet-mini-05-saas-multi-utilisateurs/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/
│   ├── migrations/            # tenants, users.tenant_id, projects, tasks
│   ├── factories/
│   └── seeders/SaasSeeder.php
├── app/
│   ├── Models/                    # Tenant, Project (scope global), Task
│   ├── Contracts/RapportGenerator.php
│   ├── Services/RapportHebdomadaireGenerator.php
│   ├── Providers/AppServiceProvider.php    # liaison interface -> implémentation
│   ├── Jobs/GenererRapportHebdomadaire.php
│   ├── Policies/ProjectPolicy.php
│   └── Http/Controllers/ProjectController.php
├── routes/web.php
├── resources/views/projects/
└── tests/Feature/
    ├── IsolationTenantTest.php     # le cœur pédagogique de ce projet
    └── RapportJobTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md).
2. [EXECUTION.md](EXECUTION.md) — y compris **lancer la suite de tests**, la meilleure façon de comprendre ce projet.
3. **Avant de lire le code fourni**, essayez d'écrire vous-même le scope global de `Project` à partir du module 08.5.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Niveau 09 — API REST avec Laravel](../../09-api-rest-laravel/README.md)
