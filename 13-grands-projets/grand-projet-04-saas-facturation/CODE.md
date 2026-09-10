# Code source complet

L'intégralité du code de ce projet existe déjà dans ce dépôt — cliquez sur un fichier pour l'ouvrir, copiez-le tel quel dans votre propre projet Laravel en suivant [INSTALLATION.md](INSTALLATION.md).

## `/`

- [Dockerfile](Dockerfile)
- [docker-compose.yml](docker-compose.yml)

## `.github/workflows`

- [.github/workflows/ci.yml](.github/workflows/ci.yml)

## `app/Console/Commands`

- [app/Console/Commands/FacturerAbonnementsCommand.php](app/Console/Commands/FacturerAbonnementsCommand.php)

## `app/Contracts`

- [app/Contracts/PaymentGateway.php](app/Contracts/PaymentGateway.php)

## `app/Exceptions`

- [app/Exceptions/LimitePlanAtteinteException.php](app/Exceptions/LimitePlanAtteinteException.php)
- [app/Exceptions/PaiementEchoueException.php](app/Exceptions/PaiementEchoueException.php)

## `app/Http/Controllers`

- [app/Http/Controllers/ProjectController.php](app/Http/Controllers/ProjectController.php)

## `app/Http/Controllers/Api`

- [app/Http/Controllers/Api/BillingController.php](app/Http/Controllers/Api/BillingController.php)

## `app/Models`

- [app/Models/Invoice.php](app/Models/Invoice.php)
- [app/Models/Plan.php](app/Models/Plan.php)
- [app/Models/Project.php](app/Models/Project.php)
- [app/Models/Subscription.php](app/Models/Subscription.php)
- [app/Models/Tenant.php](app/Models/Tenant.php)

## `app/Providers`

- [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php)

## `app/Services`

- [app/Services/BillingService.php](app/Services/BillingService.php)
- [app/Services/FakePaymentGateway.php](app/Services/FakePaymentGateway.php)
- [app/Services/PlanLimitService.php](app/Services/PlanLimitService.php)

## `database/migrations`

- [database/migrations/2024_07_01_000001_create_tenants_and_plans_tables.php](database/migrations/2024_07_01_000001_create_tenants_and_plans_tables.php)
- [database/migrations/2024_07_01_000002_create_subscriptions_and_invoices_tables.php](database/migrations/2024_07_01_000002_create_subscriptions_and_invoices_tables.php)

## `database/seeders`

- [database/seeders/SaasFacturationSeeder.php](database/seeders/SaasFacturationSeeder.php)

## `resources/views/projects`

- [resources/views/projects/index.blade.php](resources/views/projects/index.blade.php)

## `routes`

- [routes/api.php](routes/api.php)
- [routes/console.php](routes/console.php)
- [routes/web.php](routes/web.php)

## `tests/Feature`

- [tests/Feature/BillingServiceTest.php](tests/Feature/BillingServiceTest.php)
- [tests/Feature/LimitePlanTest.php](tests/Feature/LimitePlanTest.php)

---

Retour au [README du projet](README.md).
