# Solutions — 08.5 Architecture modulaire et multi-tenancy

## Exercice 1

Fichiers liés à "Annonce" : `Annonce.php`, `AnnonceController.php`,
`AnnoncePolicy.php`, `StoreAnnonceRequest.php`, `UpdateAnnonceRequest.php`,
`NouveauMessageNotification.php` — soit 6 fichiers, répartis dans 4 dossiers
différents (`Models`, `Http/Controllers`, `Policies`, `Http/Requests`,
`Notifications`). Ce nombre reste très gérable avec la structure Laravel
par défaut ; une réorganisation par domaine ajouterait de la complexité
(configuration d'autoload, navigation moins standard) sans bénéfice réel
à cette échelle. **Conclusion : ce projet n'a pas besoin d'être réorganisé.**

## Exercice 2

```php
Schema::create('projets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tenant_id')->constrained();
    $table->string('nom');
});
```
```php
$tenant1 = Tenant::create(['nom' => 'Entreprise A']);
$tenant2 = Tenant::create(['nom' => 'Entreprise B']);
Projet::create(['tenant_id' => $tenant1->id, 'nom' => 'Projet A1']);
Projet::create(['tenant_id' => $tenant2->id, 'nom' => 'Projet B1']);
```

## Exercice 3

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
Projet::all(); // ne retourne que les projets de tenant_id = 1
```

## Exercice 4

```php
DB::table('projets')->get();
// Retourne TOUS les projets, tous tenants confondus : "Projet A1" ET "Projet B1",
// car DB:: (Query Builder brut) n'a AUCUNE connaissance du scope global
// défini sur le modèle Eloquent Projet — ce scope n'existe QUE sur Eloquent.
```
Cette découverte justifie une règle d'équipe explicite : dans une
application multi-tenant par colonne, **toute** requête sur une table
isolée par tenant doit obligatoirement passer par le modèle Eloquent
concerné (jamais `DB::table()` directement), et cette règle mérite d'être
vérifiée par une revue de code systématique, voire une règle PHPStan
personnalisée détectant les usages de `DB::table()` sur les tables
sensibles.

## Exercice 5

```markdown
# STRATEGIE.md — Choix de multi-tenancy pour un SaaS médical

Contexte : données de santé, fortement réglementées (équivalent RGPD/HDS
en France), clients (cabinets médicaux) à forte sensibilité sur la
confidentialité.

Stratégie retenue : **une base de données par tenant**.

Justification :
- Isolation MAXIMALE : une faille applicative dans le filtrage ne peut
  JAMAIS exposer les données d'un autre cabinet, car elles sont physiquement
  dans une base séparée — contrairement à la stratégie tenant_id, où un
  bug de code (oubli du scope, requête DB:: brute) expose immédiatement
  tous les tenants.
- Conformité réglementaire : plus simple de démontrer à un auditeur
  qu'un cabinet ne PEUT PAS accéder aux données d'un autre, plutôt que
  de prouver qu'un mécanisme de filtrage applicatif est infaillible.
- Coût accepté : la complexité opérationnelle plus élevée (une migration
  à rejouer sur N bases, une sauvegarde par base) est un compromis
  acceptable face à l'enjeu réglementaire et de confiance client, dans
  ce secteur spécifique.

Pour un SaaS B2B classique moins sensible (ex: gestion de projets), la
stratégie tenant_id resterait le bon choix par défaut : complexité
moindre, coût d'infrastructure réduit, risque acceptable avec une
discipline de code rigoureuse.
```
