# Mini-project: Multi-user SaaS

> **Status:** ✅ Available

## 🎯 Learning objective

Build a **multi-tenant** project management SaaS: each organization (tenant) sees only its own data, with background processing, caching, interface-based dependency injection, and a Pest test suite specifically covering isolation between tenants — the most critical security risk of this kind of architecture.

## 📋 Modules used

- [08.1 — Jobs, Queues, Events, Listeners](../01-jobs-queues-events-listeners/README.en.md) (`GenererRapportHebdomadaire`)
- [08.2 — Cache and Optimization](../02-cache-optimisation-performance/README.en.md) (dashboard statistics, cache parameterized per tenant)
- [08.3 — Testing with Pest](../03-tests-pest-phpunit-laravel/README.en.md) (`Queue::fake()`, isolation tests)
- [08.4 — Service Providers and Packages](../04-packages-service-providers-personnalises/README.en.md) (`RapportGenerator` bound to `RapportHebdomadaireGenerator`)
- [08.5 — Modular Architecture and Multi-tenancy](../05-architecture-modulaire/README.en.md) (`tenant_id` global scope)

## 🧠 What you'll learn

- Implement the column-based multi-tenancy strategy (`tenant_id`) with an Eloquent global scope, **and** write the tests that concretely prove isolation between two organizations.
- Make a global scope (automatic protection) and a Policy (a second, explicit line of defense) coexist on the same model.
- Inject an interface (`RapportGenerator`) into a Job processed in the background, exactly as in a controller.
- Cache statistics **per tenant**, with invalidation at the right time.

## 📂 Project structure

Files to add to a Laravel project with Breeze installed:

```
projet-mini-05-saas-multi-utilisateurs/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/
│   ├── migrations/            # tenants, users.tenant_id, projects, tasks
│   ├── factories/
│   └── seeders/SaasSeeder.php
├── app/
│   ├── Models/                    # Tenant, Project (global scope), Task
│   ├── Contracts/RapportGenerator.php
│   ├── Services/RapportHebdomadaireGenerator.php
│   ├── Providers/AppServiceProvider.php    # interface -> implementation binding
│   ├── Jobs/GenererRapportHebdomadaire.php
│   ├── Policies/ProjectPolicy.php
│   └── Http/Controllers/ProjectController.php
├── routes/web.php
├── resources/views/projects/
└── tests/Feature/
    ├── IsolationTenantTest.php     # this project's pedagogical core
    └── RapportJobTest.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md).
2. [EXECUTION.md](EXECUTION.en.md) — including **running the test suite**, the best way to understand this project.
3. **Before reading the provided code**, try writing `Project`'s global scope yourself, based on module 08.5.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process.
5. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Level 09 — REST API with Laravel](../../09-api-rest-laravel/README.en.md)
