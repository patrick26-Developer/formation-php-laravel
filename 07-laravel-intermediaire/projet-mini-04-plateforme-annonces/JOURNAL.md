# Journal de construction

## Étape 1 — Partir de Breeze, pas de zéro

Contrairement au blog du niveau 06 (sans authentification, par choix pédagogique), ce projet **démarre** par l'installation de Breeze (module 07.4). Toute la mécanique d'inscription/connexion/déconnexion est déjà générée et testée par la communauté Laravel — le travail de ce mini-projet porte sur ce qui s'ajoute **par-dessus** : le métier des petites annonces.

## Étape 2 — Le schéma : quatre tables, deux natures de relations

`categories` → `annonces` (1-N classique, comme le blog), `annonces` → `messages` (1-N, les messages de contact), et `favorites` (table pivot N-N entre `users` et `annonces`, sans colonne supplémentaire — juste `withTimestamps()` pour savoir quand l'ajout a eu lieu). Remarquez `restrictOnDelete()` sur `categorie_id` plutôt que `cascadeOnDelete()` comme dans le blog : supprimer une catégorie ayant des annonces actives est **volontairement bloqué**, pour éviter de supprimer accidentellement des annonces réelles d'utilisateurs — un choix métier différent de celui du blog, où les articles étaient moins "précieux".

## Étape 3 — La Policy avant le contrôleur

`AnnoncePolicy` est écrite **avant** de brancher quoi que ce soit dans `AnnonceController` : `update()` et `delete()` vérifient toutes deux `$user->id === $annonce->user_id`. `UpdateAnnonceRequest::authorize()` délègue entièrement à cette Policy (`$this->user()?->can('update', ...)`) plutôt que de dupliquer la condition — la même centralisation recommandée à l'exercice 5 du [module 07.5](../05-autorisations-policies-gates/README.md). Le contrôleur, lui, appelle `$this->authorize()` sur `edit()`/`destroy()` : trois points d'entrée (Form Request, contrôleur, vue via `@can`) qui interrogent tous la **même** source de vérité.

## Étape 4 — L'upload, du formulaire au nettoyage

`StoreAnnonceRequest`/`UpdateAnnonceRequest` valident l'image (`image|mimes:...|max:2048`). Le contrôleur gère le remplacement (suppression de l'ancien fichier avant stockage du nouveau, module 07.6). La suppression définitive est déléguée à un **Model Event** (`static::deleting()` dans `Annonce::booted()`) plutôt qu'au contrôleur : ainsi, peu importe comment une annonce est supprimée (interface, Tinker, une future commande de modération), son fichier image est **toujours** nettoyé — la même logique que l'exercice 5 du module 07.6.

## Étape 5 — La notification, déclenchée par un visiteur anonyme

Le point le plus intéressant de ce projet : `MessageController::store()` est une route **publique** (pas de `middleware('auth')`), mais elle déclenche `$annonce->user->notify(...)` — une notification vers un utilisateur **authentifié**, provoquée par une action d'un visiteur qui, lui, ne l'est pas. C'est un rappel important : l'authentification protège des **actions**, pas la capacité de **déclencher un effet** sur le compte d'un utilisateur connecté par un mécanisme prévu à cet effet (ici, un formulaire de contact public, un cas d'usage légitime).

## Étape 6 — Les favoris, la relation N-N la plus simple

`favoris()` sur `User` et `favoritedBy()` sur `Annonce` sont de simples `belongsToMany` sans colonne pivot personnalisée (contrairement à un cas nécessitant `withPivot`, vu au module 07.1). `FavoriteController::toggle()` illustre le pattern `attach()`/`detach()` conditionnel — une alternative à `sync()` quand on gère une seule relation à la fois plutôt qu'un ensemble complet.

## Pour aller plus loin (hors scope de ce mini-projet)

Aucune limite n'est mise sur le nombre d'annonces par utilisateur, aucune modération n'existe avant publication, et les messages ne sont pas eux-mêmes protégés contre le spam (pas de CAPTCHA ni de limitation de fréquence). Ces sujets, notamment le **rate limiting**, sont traités en détail au [module 09.6](../../09-api-rest-laravel/06-rate-limiting-securite-api/README.md).
