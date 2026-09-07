# Journal de construction

## Étape 1 — Reprendre le multi-tenant du niveau 08, sans le réinventer

`Project` utilise EXACTEMENT le même scope global que le mini-projet du [module 08.5](../../08-laravel-avance/05-architecture-modulaire/README.md) : filtrage automatique par `tenant_id`, assignation automatique à la création. Ce niveau ne réintroduit rien de nouveau sur ce point précis — il **construit par-dessus**, avec une règle métier active : les limites de plan.

## Étape 2 — `PlanLimitService`, un seul endroit pour toute règle de plan

Plutôt que de disperser des vérifications `if ($tenant->projects->count() >= ...)` dans chaque contrôleur qui créerait une ressource limitée par plan, `PlanLimitService::verifierLimiteProjets()` centralise cette logique. Le jour où une deuxième limite doit être introduite (nombre d'utilisateurs par tenant, par exemple), elle rejoint ce même service — jamais dispersée.

## Étape 3 — La décision transactionnelle la plus importante du projet

`OrderService` (grand projet e-commerce) et `BillingService` (ce projet) utilisent tous deux `DB::transaction()` autour d'un appel à `PaymentGateway::payer()` — mais avec un comportement **opposé** en cas d'échec :

- **E-commerce** : un paiement refusé annule TOUT (commande, décrémentation de stock) — l'achat n'a simplement pas eu lieu.
- **Facturation d'abonnement** (ce projet) : un paiement refusé laisse la facture "impayee" **persistée**, car l'important est de **garder une trace** pour permettre une relance commerciale, pas de faire disparaître l'obligation de paiement du client.

Techniquement, cela se traduit par un `try/catch` qui **catch et retourne** au lieu de relancer l'exception à l'intérieur de `facturer()` — puisque relancer l'exception aurait déclenché le rollback automatique de `DB::transaction()`, supprimant la facture. Cette nuance est **le point le plus important** de ce grand projet : deux mécanismes transactionnels identiques en apparence, deux décisions métier opposées, chacune testée explicitement (`BillingServiceTest`) pour ne jamais être "corrigée" par erreur lors d'une future modification.

## Étape 4 — La facturation planifiée, du scheduler au conteneur dédié

`FacturerAbonnementsCommand` (module 06.1/12) est déclarée dans `routes/console.php` via `Schedule::command(...)->dailyAt('03:00')` (module 08.1/11.4). Dans `docker-compose.yml`, un conteneur `scheduler` séparé exécute `php artisan schedule:work` en continu — la même philosophie qu'au [module 11.1](../../11-devops-docker-cicd-avance/01-dockerisation-application-laravel-complete/README.md) pour le worker de queue : une responsabilité, un conteneur.

## Étape 5 — Un pipeline CI/CD complet, comme modèle réutilisable

`.github/workflows/ci.yml` reprend fidèlement la structure du [module 11.3](../../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md) : service MySQL éphémère, migrations, tests, puis (conditionné à `github.ref == 'refs/heads/main'`, pour ne jamais publier une image depuis une branche de développement) build et push vers `ghcr.io`. Ce fichier est pensé comme un **modèle directement copiable** pour n'importe lequel des autres projets de cette formation.

## Pour aller plus loin (hors scope de ce projet)

Aucune interface d'administration pour créer/modifier les plans, aucun changement de plan en libre-service par le client (upgrade/downgrade), et le paiement reste entièrement simulé — une intégration Stripe réelle suivrait le même schéma que celui esquissé au [grand projet e-commerce](../grand-projet-02-ecommerce-minimal/README.md).
