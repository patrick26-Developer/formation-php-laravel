# Grand projet : SaaS de facturation multi-tenant

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Le projet de synthèse final de la formation : un SaaS multi-tenant avec plans d'abonnement, facturation périodique automatisée, application des limites de plan, API, Docker et pipeline CI/CD complet — assemblant les niveaux 04, 07, 08, 09 et 11.

## 📋 Modules mobilisés

- [08.5 — Architecture modulaire et multi-tenancy](../../08-laravel-avance/05-architecture-modulaire/README.md) (scope global `tenant_id`, repris et étendu)
- [04.2 — Transactions](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.md) (facturation transactionnelle, avec une nuance importante — voir JOURNAL)
- [08.1 — Jobs et scheduler](../../08-laravel-avance/01-jobs-queues-events-listeners/README.md) (`routes/console.php`, facturation planifiée)
- [11.1/11.3 — Docker et CI/CD](../../11-devops-docker-cicd-avance/README.md) (Dockerfile, docker-compose, pipeline GitHub Actions complet)
- [09 — API REST avec Laravel](../../09-api-rest-laravel/README.md) (consultation d'abonnement/factures via Sanctum)

## 🧠 Ce que vous allez apprendre

- Étendre l'isolation multi-tenant (module 08.5) avec une **règle métier active** : chaque tenant est plafonné par son plan, vérifiée à chaque tentative de création.
- Différencier deux besoins transactionnels distincts : un achat (grand projet e-commerce) où l'échec de paiement doit **tout annuler**, contre une facturation d'abonnement où l'échec doit **laisser une trace** (facture impayée) pour permettre une relance — la même mécanique technique (`DB::transaction`), deux décisions métier opposées.
- Planifier une tâche récurrente avec le scheduler Laravel, et l'opérer dans Docker via un conteneur `scheduler` dédié.
- Fournir un pipeline CI/CD complet et prêt à l'emploi (tests avec MySQL éphémère, build et push d'image Docker taguée par SHA) pour ce projet, à titre de modèle réutilisable pour toute application développée avec cette formation.

## 📂 Structure du projet

```
grand-projet-04-saas-facturation/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── Dockerfile / docker-compose.yml
├── .github/workflows/ci.yml
├── database/{migrations,seeders}/
├── app/
│   ├── Models/                  # Tenant, Plan, Subscription, Invoice, Project
│   ├── Contracts/PaymentGateway.php
│   ├── Services/                  # PlanLimitService, BillingService, FakePaymentGateway
│   ├── Console/Commands/FacturerAbonnementsCommand.php
│   └── Http/Controllers/            # ProjectController, Api/BillingController
├── routes/{web.php,api.php,console.php}
└── tests/Feature/                     # LimitePlanTest, BillingServiceTest
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md).
2. [EXECUTION.md](EXECUTION.md) — lancez d'abord `LimitePlanTest` et `BillingServiceTest`.
3. **Avant de lire le code fourni**, essayez de concevoir vous-même `PlanLimitService::verifierLimiteProjets()`.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction, notamment la décision transactionnelle du `BillingService`.

**Ce grand projet clôt la partie pratique de la formation.** Suite : [Niveau 14 — Préparation professionnelle](../../14-preparation-professionnelle/README.md)
