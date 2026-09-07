# Journal de construction

## Étape 1 — Une table pivot, deux directions de lecture

`follows` a deux colonnes (`follower_id`, `followed_id`) pointant toutes deux vers `users`. `User::following()` et `User::followers()` interrogent la **même table**, mais avec les colonnes locale/étrangère inversées (`belongsToMany(User::class, 'follows', 'follower_id', 'followed_id')` vs l'inverse). C'est l'application directe de la relation auto-référencée du [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md), avec la difficulté supplémentaire que la table pivot relie un modèle à **lui-même**.

## Étape 2 — Le fil d'actualité : une seule requête, pas une boucle

`feed()` calcule d'abord la liste des IDs pertinents (`following()->pluck('users.id')->push($utilisateur->id)`), PUIS lance une seule requête `whereIn('user_id', $idsSuivis)`. L'alternative — boucler sur chaque compte suivi et fusionner les résultats en PHP — aurait été un piège de performance direct, le problème N+1 (module 03.6) appliqué à une logique métier plutôt qu'à un simple affichage de relation.

## Étape 3 — Notifier avec discernement, pas systématiquement

Deux garde-fous explicites empêchent des notifications inutiles ou absurdes : `FollowController::basculer()` refuse qu'un utilisateur se suive lui-même (`if ($utilisateurConnecte->id === $user->id)`), et `LikeController::basculer()` ne notifie l'auteur QUE si le "likeur" n'est pas l'auteur lui-même. Sans ces vérifications, un utilisateur recevrait une notification "vous avez commencé à vous suivre" ou "vous avez aimé votre propre publication" — un bruit inutile qui dégraderait rapidement la confiance dans le centre de notifications.

## Étape 4 — Le même modèle, deux présentations

`PostResource` (utilisée par `Api\FeedController`) calcule `aime_par_moi` via `estAimeParL($request->user())`, la MÊME méthode que la vue Blade (`posts/feed.blade.php`) utilise pour afficher ❤️/🤍. Aucune logique n'est dupliquée entre les deux surfaces (web et API) — seule la représentation finale (HTML vs JSON) diffère, exactement le principe déjà appliqué au [mini-projet du niveau 09](../../09-api-rest-laravel/projet-mini-06-api-rest-complete/README.md).

## Étape 5 — `withCount`/`whenCounted` plutôt que charger toute la relation

L'API utilise `withCount('likedBy')` puis `whenCounted('likedBy')` dans la Resource — cela ne récupère qu'un **nombre** (`likedBy_count`), pas la liste complète des utilisateurs ayant aimé chaque post (potentiellement des centaines), inutile pour un simple affichage de compteur. La vue Blade, elle, charge la relation complète (`likedBy`) car elle a besoin de savoir si l'utilisateur CONNECTÉ précisément en fait partie — deux besoins différents, deux stratégies de chargement différentes, toutes deux délibérées.

## Pour aller plus loin (hors scope de ce projet)

Aucun système de commentaires, de partage, ni de fil "découverte" (suggestions de comptes à suivre) — le cœur minimal (publier, suivre, aimer, être notifié) est complet, le reste est une extension naturelle laissée en exercice.
