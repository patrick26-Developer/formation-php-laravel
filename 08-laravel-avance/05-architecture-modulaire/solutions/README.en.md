# Solutions — 08.5 Modular Architecture and Multi-tenancy

## Exercise 1

Files related to "Annonce": `Annonce.php`, `AnnonceController.php`,
`AnnoncePolicy.php`, `StoreAnnonceRequest.php`, `UpdateAnnonceRequest.php`,
`NouveauMessageNotification.php` — 6 files, spread across 4 different
folders (`Models`, `Http/Controllers`, `Policies`, `Http/Requests`,
`Notifications`). This count remains very manageable with Laravel's
default structure; a domain-driven reorganization would add complexity
(extra autoloading configuration, less standard navigation) with no real
benefit at this scale. **Conclusion: this project doesn't need to be reorganized.**

## Exercise 2

```php
Schema::create('projets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained();
    $table->string('nom');
});
```
```php
$tenant1 = Tenant::create(['nom' => 'Company A']);
$tenant2 = Tenant::create(['nom' => 'Company B']);
Projet::create(['tenant_id' => $tenant1->id, 'nom' => 'Project A1']);
Projet::create(['tenant_id' => $tenant2->id, 'nom' => 'Project B1']);
```

## Exercise 3

```php
class Projet extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('tenant_id', auth()->user()->tenant_id);
            }
        });
    }
}
```
```php
// Tinker
Auth::loginUsingId($utilisateurDuTenant1->id);
Projet::all(); // only returns projects with tenant_id = 1
```

## Exercise 4

```php
DB::table('projets')->get();
// Returns ALL projects, across every tenant: "Project A1" AND "Project B1",
// because DB:: (raw Query Builder) has NO knowledge whatsoever of the
// global scope defined on the Eloquent Projet model — that scope exists
// ONLY on Eloquent.
```
This discovery justifies an explicit team rule: in a column-based
multi-tenant application, **every** query on a tenant-isolated table
must go through the relevant Eloquent model (never `DB::table()`
directly), and this rule deserves to be checked via systematic code
review, or even a custom PHPStan rule detecting `DB::table()` usage on
sensitive tables.

## Exercise 5

```markdown
# STRATEGIE.md — Multi-tenancy choice for a medical SaaS

Context: health data, heavily regulated (the French equivalent of
GDPR/HDS), customers (medical practices) with high sensitivity around
confidentiality.

Chosen strategy: **one database per tenant**.

Justification:
- MAXIMUM isolation: an application flaw in the filtering can NEVER
  expose another practice's data, since it's physically in a separate
  database — unlike the tenant_id strategy, where a code bug (a missed
  scope, a raw DB:: query) immediately exposes every tenant.
- Regulatory compliance: much simpler to demonstrate to an auditor that
  one practice CANNOT access another's data, rather than proving an
  application-level filtering mechanism is infallible.
- Accepted cost: the higher operational complexity (a migration to
  replay across N databases, a backup per database) is an acceptable
  trade-off given the regulatory stakes and client trust, in this
  specific sector.

For a classic, less sensitive B2B SaaS (e.g., project management), the
tenant_id strategy would remain the right default choice: lower
complexity, reduced infrastructure cost, an acceptable risk with
rigorous coding discipline.
```
