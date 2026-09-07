# Large Project: Multi-tenant Billing SaaS

> **Status:** ✅ Available

## 🎯 Learning objective

The training's final synthesis project: a multi-tenant SaaS with subscription plans, automated periodic billing, plan-limit enforcement, an API, Docker, and a complete CI/CD pipeline — bringing together levels 04, 07, 08, 09, and 11.

## 📋 Modules used

- [08.5 — Modular Architecture and Multi-tenancy](../../08-laravel-avance/05-architecture-modulaire/README.en.md) (the `tenant_id` global scope, reused and extended)
- [04.2 — Transactions](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.en.md) (transactional billing, with an important nuance — see the JOURNAL)
- [08.1 — Jobs and Scheduler](../../08-laravel-avance/01-jobs-queues-events-listeners/README.en.md) (`routes/console.php`, scheduled billing)
- [11.1/11.3 — Docker and CI/CD](../../11-devops-docker-cicd-avance/README.en.md) (Dockerfile, docker-compose, a complete GitHub Actions pipeline)
- [09 — REST API with Laravel](../../09-api-rest-laravel/README.en.md) (viewing a subscription/invoices via Sanctum)

## 🧠 What you'll learn

- Extend multi-tenant isolation (module 08.5) with an **active business rule**: each tenant is capped by its plan, checked on every creation attempt.
- Distinguish two different transactional needs: a purchase (the e-commerce large project) where a payment failure must **cancel everything**, versus subscription billing where a failure must **leave a trace** (an unpaid invoice) to allow follow-up — the same technical mechanism (`DB::transaction`), two opposite business decisions.
- Schedule a recurring task with Laravel's scheduler, and operate it in Docker via a dedicated `scheduler` container.
- Provide a complete, ready-to-use CI/CD pipeline (tests against an ephemeral MySQL, building and pushing a Docker image tagged by SHA) for this project, as a reusable template for any application built with this training.

## 📂 Project structure

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

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md).
2. [EXECUTION.md](EXECUTION.en.md) — start by running `LimitePlanTest` and `BillingServiceTest`.
3. **Before reading the provided code**, try designing `PlanLimitService::verifierLimiteProjets()` yourself.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process, especially `BillingService`'s transactional decision.

**This large project closes out the training's practical section.** Next: [Level 14 — Professional Preparation](../../14-preparation-professionnelle/README.en.md)
