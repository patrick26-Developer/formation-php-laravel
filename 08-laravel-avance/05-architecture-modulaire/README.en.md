# 08.5 — Modular Architecture and Multi-tenancy

> **Status:** ✅ Available

## 🎯 Objectives

- Recognize the signs that a Laravel application needs to be reorganized.
- Structure an application by business domain rather than technical type.
- Understand the basic strategies of multi-tenancy.
- Choose a data isolation strategy suited to the need.

## 📋 Prerequisites

[08.4 — Service Providers and Custom Packages](../04-packages-service-providers-personnalises/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### The problem: `app/Models/` and `app/Http/Controllers/` overflowing

Laravel's default structure (one folder per **technical type**: all models together, all controllers together) works well for a small application. On an application with 40+ models and 60+ controllers, finding "everything related to billing" becomes painful — related files are scattered across several unrelated folders.

### A domain-driven architecture (overview)

```
app/
├── Domain/
│   ├── Annonces/
│   │   ├── Models/Annonce.php
│   │   ├── Http/Controllers/AnnonceController.php
│   │   ├── Policies/AnnoncePolicy.php
│   │   └── Notifications/NouveauMessageNotification.php
│   ├── Facturation/
│   │   ├── Models/Abonnement.php
│   │   ├── Services/StripeGateway.php
│   │   └── Http/Controllers/AbonnementController.php
│   └── Utilisateurs/
│       ├── Models/User.php
│       └── Policies/UserPolicy.php
```

> 💡 This organization groups **everything related to a single business responsibility** in one place, instead of scattering it by technical type. This is the single responsibility principle (module 03.5) applied not to a class, but to **folder organization**: a change in "Annonces" never touches files from another domain.

> ⚠️ **Never reorganize a project in anticipation.** This structure has a cost (extra autoloading configuration, less obvious navigation for a new developer used to the default structure). It's justified once the number of files makes the default structure **genuinely** painful — not before. A mini-project from this training, or an application with fewer than 15-20 models, generally doesn't need it.

### Multi-tenancy: several customers on one application

**Multi-tenancy** lets a single installation of the application serve several customers (organizations, companies) that are fully isolated from each other. Three main strategies:

| Strategy | Isolation | Complexity | Typical use case |
|---|---|---|---|
| **One database per tenant** | Maximum (physically separate databases) | High (migrations to replay on each database) | Highly sensitive data, strong regulatory requirements |
| **One schema per tenant** | Strong (especially PostgreSQL) | Medium | A compromise between isolation and simplicity |
| **`tenant_id` column** (most common) | Logical (same database, application-level filtering) | Low to set up | Most mid-sized B2B SaaS products |

### Implementing the `tenant_id` strategy (the most accessible)

```php
// Migration
Schema::table('annonces', function (Blueprint $table) {
    $table->foreignId('tenant_id')->constrained();
});
```

```php
// A global scope (module 07.2), applied automatically everywhere
class Annonce extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });

        static::creating(function (Annonce $annonce) {
            $annonce->tenant_id ??= auth()->user()?->tenant_id;
        });
    }
}
```

> ⚠️ **The number-one risk of column-based multi-tenancy**: a developer who writes a `DB::table('annonces')->get()` query (outside of Eloquent, thus **without** the global scope) would accidentally bypass tenant isolation, exposing one customer's data to another. This is a critical security flaw in a SaaS environment — the discipline of always going through Eloquent (or a Repository that systematically applies the filter) is essential as soon as a project adopts this strategy.

## ✅ Key takeaways

- A domain-driven architecture groups code by business responsibility rather than technical type — reserved for projects that genuinely need it.
- Multi-tenancy isolates data from several customers on the same application; three strategies exist, from most isolated (separate databases) to simplest (`tenant_id` column).
- The `tenant_id` column strategy is the most common, but requires strict discipline (always going through Eloquent/a global scope) to avoid data leaking between tenants.
- Never over-architect in anticipation: complexity must be justified by an observed real need.

## ➡️ Going further

- [laravel.com/docs — Service Container (contextual binding)](https://laravel.com/docs/container#contextual-binding)
- [Module 13.4 — Large Project: Multi-tenant Billing SaaS](../../13-grands-projets/grand-projet-04-saas-facturation/README.en.md) (multi-tenancy applied under real conditions)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [08.4 — Service Providers and Packages](../04-packages-service-providers-personnalises/README.en.md) · **Next:** [Mini-project: Multi-user SaaS](../projet-mini-05-saas-multi-utilisateurs/README.en.md)
