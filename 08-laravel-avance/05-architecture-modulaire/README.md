# 08.5 — Architecture modulaire et multi-tenancy

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Reconnaître les signes qu'une application Laravel a besoin d'être réorganisée.
- Structurer une application par domaine métier plutôt que par type technique.
- Comprendre les stratégies de base du multi-tenancy (multi-locataires).
- Choisir une stratégie d'isolation des données adaptée au besoin.

## 📋 Prérequis

[08.4 — Service Providers et packages personnalisés](../04-packages-service-providers-personnalises/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Le problème : `app/Models/` et `app/Http/Controllers/` qui débordent

La structure par défaut de Laravel (un dossier par **type technique** : tous les modèles ensemble, tous les contrôleurs ensemble) fonctionne bien pour une petite application. Sur une application avec 40+ modèles et 60+ contrôleurs, retrouver "tout ce qui concerne la facturation" devient pénible — les fichiers liés sont dispersés dans plusieurs dossiers sans rapport apparent.

### Une architecture par domaine (aperçu)

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

> 💡 Cette organisation regroupe **tout ce qui concerne une même responsabilité métier** au même endroit, au lieu de l'éparpiller par type technique. C'est le principe de responsabilité unique (module 03.5) appliqué non plus à une classe, mais à l'**organisation des dossiers** : un changement dans "Annonces" ne touche jamais aux fichiers d'un autre domaine.

> ⚠️ **Ne réorganisez jamais un projet par anticipation.** Cette structure a un coût (configuration d'autoloading supplémentaire, navigation moins évidente pour un nouveau développeur habitué à la structure par défaut). Elle se justifie à partir du moment où le nombre de fichiers rend **réellement** la structure par défaut pénible — pas avant. Un mini-projet de cette formation, ou une application avec moins de 15-20 modèles, n'en a généralement pas besoin.

### Multi-tenancy : plusieurs clients sur une même application

Le **multi-tenancy** ("multi-locataires") permet à une seule installation de l'application de servir plusieurs clients (organisations, entreprises) totalement isolés les uns des autres. Trois stratégies principales :

| Stratégie | Isolation | Complexité | Cas d'usage typique |
|---|---|---|---|
| **Une base par tenant** | Maximale (bases physiquement séparées) | Élevée (migrations à rejouer sur chaque base) | Données très sensibles, exigences réglementaires fortes |
| **Un schéma par tenant** | Forte (PostgreSQL notamment) | Moyenne | Compromis isolation/simplicité |
| **Colonne `tenant_id`** (la plus courante) | Logique (même base, filtrage applicatif) | Faible à mettre en place | La majorité des SaaS B2B de taille moyenne |

### Implémenter la stratégie `tenant_id` (la plus accessible)

```php
// Migration
Schema::table('annonces', function (Blueprint $table) {
    $table->foreignId('tenant_id')->constrained();
});
```

```php
// Un scope global (module 07.2), appliqué automatiquement partout
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

> ⚠️ **Le risque numéro un du multi-tenancy par colonne** : un développeur qui écrit une requête `DB::table('annonces')->get()` (en dehors d'Eloquent, donc **sans** le scope global) contournerait accidentellement l'isolation entre tenants, exposant les données d'un client à un autre. C'est une faille de sécurité critique en environnement SaaS — la discipline de toujours passer par Eloquent (ou par un Repository qui applique systématiquement le filtre) est essentielle dès qu'un projet adopte cette stratégie.

## ✅ Points clés à retenir

- Une architecture par domaine regroupe le code par responsabilité métier plutôt que par type technique — à réserver aux projets qui en ressentent réellement le besoin.
- Le multi-tenancy isole les données de plusieurs clients sur une même application ; trois stratégies existent, du plus isolé (bases séparées) au plus simple (colonne `tenant_id`).
- La stratégie par colonne `tenant_id` est la plus courante, mais exige une discipline stricte (toujours passer par Eloquent/un scope global) pour éviter une fuite de données entre tenants.
- Ne jamais sur-architecturer par anticipation : la complexité doit être justifiée par un besoin réel constaté.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Service Container (bindings contextuels)](https://laravel.com/docs/container#contextual-binding)
- [Module 13.4 — Grand projet SaaS de facturation multi-tenant](../../13-grands-projets/grand-projet-04-saas-facturation/README.md) (multi-tenancy appliqué en conditions réelles)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [08.4 — Service Providers et packages](../04-packages-service-providers-personnalises/README.md) · **Suite :** [Mini-projet : SaaS multi-utilisateurs](../projet-mini-05-saas-multi-utilisateurs/README.md)
