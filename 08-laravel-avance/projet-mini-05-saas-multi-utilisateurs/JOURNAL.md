# Journal de construction

## Étape 1 — Le choix de stratégie multi-tenant, assumé et documenté

Conformément au [module 08.5](../05-architecture-modulaire/README.md), ce projet adopte la stratégie la plus simple (colonne `tenant_id`), adaptée à un SaaS B2B de gestion de projets sans exigence réglementaire extrême — contrairement au cas du secteur médical discuté à l'exercice 5 du même module, qui justifierait une base par tenant.

## Étape 2 — Le scope global, écrit avant tout le reste

`Project::booted()` définit le scope global `tenant` **avant** d'écrire le moindre contrôleur : cette décision structure tout ce qui suit. `static::creating()` complète le dispositif en assignant automatiquement `tenant_id` à la création, pour qu'aucun contrôleur n'ait jamais à s'en souvenir explicitement — une garantie côté modèle plutôt qu'une discipline à respecter partout où un projet est créé.

## Étape 3 — Policy en seconde ligne, pas en premier rempart

`ProjectPolicy::view()`/`update()`/`delete()` vérifient à nouveau `tenant_id`, alors que le scope global rend déjà quasiment impossible d'atteindre un projet d'un autre tenant via le Model Binding (module 06.2) — Laravel renverrait 404 avant même d'appeler la Policy. Cette redondance est **volontaire** : elle documente explicitement l'invariant métier ("un projet appartient à un seul tenant"), et protège même dans un scénario où le scope global serait un jour retiré par erreur (`withoutGlobalScope` mal utilisé, refactoring imprudent).

## Étape 4 — L'injection d'interface, jusque dans un Job

`RapportGenerator` est lié à `RapportHebdomadaireGenerator` dans `AppServiceProvider` (module 08.4). Le point notable : `GenererRapportHebdomadaire::handle(RapportGenerator $generateur)` reçoit cette dépendance **exactement comme un contrôleur** — le Service Container de Laravel résout les dépendances des Jobs traités par un worker de la même façon que celles d'une requête HTTP. `RapportHebdomadaireGenerator` utilise volontairement `withoutGlobalScope('tenant')` : un Job en arrière-plan n'a pas d'utilisateur "connecté" au sens HTTP, le scope basé sur `auth()->check()` ne s'appliquerait de toute façon pas utilement ici — le filtrage se fait explicitement via `$tenant->projects()`.

## Étape 5 — Le cache, invalidé au bon moment

Les statistiques du tableau de bord sont mises en cache par tenant (`"dashboard.statistiques.tenant.{$tenantId}"`, module 08.2). L'invalidation (`Cache::forget()`) a lieu explicitement dans `store()` et `destroy()` — les deux seuls endroits qui modifient le nombre de projets d'un tenant. Un futur endpoint qui créerait des projets par un autre chemin (import en masse, API) devra impérativement invalider ce même cache, sous peine d'afficher des statistiques obsolètes pendant 10 minutes.

## Étape 6 — Les tests, centrés sur le risque réel

`IsolationTenantTest` ne teste pas des détails d'implémentation, mais le **risque métier le plus grave** de ce projet : une fuite de données entre tenants. C'est délibérément le premier fichier de test écrit, avant même les tests plus classiques de `RapportJobTest` — dans un projet multi-tenant réel, ce type de test devrait toujours être prioritaire sur la couverture de test générale.

## Pour aller plus loin (hors scope de ce mini-projet)

Aucune limite de plan (nombre de projets, d'utilisateurs) n'est mise en place — un vrai SaaS facturerait généralement par palier. Ce sujet, avec la gestion des abonnements et des paiements, est traité en profondeur au [grand projet du niveau 13](../../13-grands-projets/grand-projet-04-saas-facturation/README.md).
