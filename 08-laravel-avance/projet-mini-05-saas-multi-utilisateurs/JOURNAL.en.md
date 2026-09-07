# Build Journal

## Step 1 — The multi-tenant strategy choice, deliberate and documented

Following [module 08.5](../05-architecture-modulaire/README.en.md), this project adopts the simplest strategy (a `tenant_id` column), suited to a B2B project-management SaaS with no extreme regulatory requirement — unlike the medical-sector case discussed in exercise 5 of that same module, which would justify a database-per-tenant approach.

## Step 2 — The global scope, written before everything else

`Project::booted()` defines the `tenant` global scope **before** writing a single controller: this decision structures everything that follows. `static::creating()` completes the setup by automatically assigning `tenant_id` on creation, so no controller ever has to remember to do it explicitly — a model-side guarantee rather than a discipline to uphold everywhere a project gets created.

## Step 3 — Policy as a second line, not the first wall

`ProjectPolicy::view()`/`update()`/`delete()` check `tenant_id` again, even though the global scope already makes it nearly impossible to reach another tenant's project via Model Binding (module 06.2) — Laravel would return 404 before the Policy is even called. This redundancy is **deliberate**: it explicitly documents the business invariant ("a project belongs to exactly one tenant"), and it still protects the application in a scenario where the global scope is one day removed by mistake (a misused `withoutGlobalScope`, a careless refactor).

## Step 4 — Interface injection, all the way into a Job

`RapportGenerator` is bound to `RapportHebdomadaireGenerator` in `AppServiceProvider` (module 08.4). The notable point: `GenererRapportHebdomadaire::handle(RapportGenerator $generateur)` receives this dependency **exactly like a controller does** — Laravel's Service Container resolves a Job's dependencies the same way it resolves an HTTP request's, when processed by a worker. `RapportHebdomadaireGenerator` deliberately uses `withoutGlobalScope('tenant')`: a background Job has no "logged-in" user in the HTTP sense, so the scope based on `auth()->check()` wouldn't usefully apply here anyway — filtering happens explicitly via `$tenant->projects()`.

## Step 5 — The cache, invalidated at the right time

Dashboard statistics are cached per tenant (`"dashboard.statistiques.tenant.{$tenantId}"`, module 08.2). Invalidation (`Cache::forget()`) happens explicitly in `store()` and `destroy()` — the only two places that change a tenant's project count. A future endpoint that creates projects through another path (bulk import, an API) will absolutely need to invalidate this same cache, or risk showing stale statistics for up to 10 minutes.

## Step 6 — Tests focused on the real risk

`IsolationTenantTest` doesn't test implementation details — it tests this project's **most serious business risk**: a data leak between tenants. It's deliberately the first test file written, even before the more conventional tests in `RapportJobTest` — in a real multi-tenant project, this kind of test should always take priority over general test coverage.

## Going further (out of scope for this mini-project)

No plan limit (number of projects, users) is implemented — a real SaaS would generally bill by tier. This topic, along with subscription and payment management, is covered in depth in the [level 13 large project](../../13-grands-projets/grand-projet-04-saas-facturation/README.md) *(French only)*.
