# Build Journal

## Step 1 — Reusing level 08's multi-tenancy, not reinventing it

`Project` uses EXACTLY the same global scope as the [module 08.5](../../08-laravel-avance/05-architecture-modulaire/README.en.md) mini-project: automatic filtering by `tenant_id`, automatic assignment on creation. This level reintroduces nothing new on this specific point — it **builds on top**, with an active business rule: plan limits.

## Step 2 — `PlanLimitService`, a single place for every plan rule

Rather than scattering `if ($tenant->projects->count() >= ...)` checks across every controller that creates a plan-limited resource, `PlanLimitService::verifierLimiteProjets()` centralizes this logic. The day a second limit needs introducing (number of users per tenant, for example), it joins this same service — never scattered.

## Step 3 — The project's most important transactional decision

`OrderService` (the e-commerce large project) and `BillingService` (this project) both use `DB::transaction()` around a call to `PaymentGateway::payer()` — but with **opposite** behavior on failure:

- **E-commerce**: a declined payment cancels EVERYTHING (order, stock decrement) — the purchase simply never happened.
- **Subscription billing** (this project): a declined payment leaves the invoice **persisted** as "unpaid", because what matters is **keeping a record** to allow a follow-up, not making the customer's payment obligation disappear.

Technically, this translates into a `try/catch` that **catches and returns** instead of rethrowing the exception inside `facturer()` — since rethrowing would have triggered `DB::transaction()`'s automatic rollback, deleting the invoice. This nuance is **the single most important point** of this large project: two transactional mechanisms identical in appearance, two opposite business decisions, each explicitly tested (`BillingServiceTest`) so neither is ever "corrected" by mistake during a future change.

## Step 4 — Scheduled billing, from the scheduler to a dedicated container

`FacturerAbonnementsCommand` (module 06.1/12) is declared in `routes/console.php` via `Schedule::command(...)->dailyAt('03:00')` (module 08.1/11.4). In `docker-compose.yml`, a separate `scheduler` container runs `php artisan schedule:work` continuously — the same philosophy as [module 11.1](../../11-devops-docker-cicd-avance/01-dockerisation-application-laravel-complete/README.en.md)'s queue worker: one responsibility, one container.

## Step 5 — A complete CI/CD pipeline, as a reusable template

`.github/workflows/ci.yml` faithfully follows the structure from [module 11.3](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.en.md): an ephemeral MySQL service, migrations, tests, then (conditioned on `github.ref == 'refs/heads/main'`, so an image is never published from a development branch) building and pushing to `ghcr.io`. This file is designed as a **directly copyable template** for any of this training's other projects.

## Going further (out of scope for this project)

No admin interface for creating/editing plans, no self-service plan changes by the customer (upgrade/downgrade), and payment remains entirely simulated — a real Stripe integration would follow the same pattern sketched out in the [e-commerce large project](../grand-projet-02-ecommerce-minimal/README.en.md).
