# Journal de construction

> Ce journal retrace la construction du projet dans l'ordre logique suivi, pour que vous puissiez reproduire la même démarche.

## Étape 1 — Le schéma de données

Avant tout code PHP, `sql/schema.sql` définit deux tables : `utilisateurs` et `taches`, liées par une clé étrangère `utilisateur_id`. Cette contrainte `FOREIGN KEY ... ON DELETE CASCADE` garantit qu'on ne peut pas créer une tâche orpheline (sans utilisateur), et que supprimer un utilisateur supprime automatiquement ses tâches.

Volontairement, **aucun mot de passe n'est écrit en dur dans le SQL** : `seed.php` crée l'utilisateur de démonstration via `password_hash()`, cohérent avec la règle du [module 02.5](../05-sessions-cookies-authentification-maison/README.md).

## Étape 2 — La connexion centralisée (`Database.php`)

Reprend directement le pattern Singleton du [module 02.8](../08-pdo-bases-de-donnees-mysql/README.md) : une seule connexion PDO par requête HTTP, lue depuis `config.php` (non versionné) plutôt que codée en dur — la première fois dans cette formation qu'une vraie séparation configuration/code est appliquée.

## Étape 3 — L'authentification (`Auth.php`)

`Auth::connecter()` vérifie l'email et le mot de passe (`password_verify()`), puis appelle `session_regenerate_id(true)` avant d'écrire en session — une précaution supplémentaire non mentionnée au module 02.5 : régénérer l'identifiant de session à la connexion empêche une attaque par **fixation de session** (un attaquant qui aurait fixé l'ID de session d'une victime *avant* sa connexion ne peut pas en profiter après, puisque l'ID change).

`Auth::exigerConnexion()` reproduit le middleware maison du module 02.5, appelé en tout début de chaque page protégée (`index.php`, `creer.php`, `modifier.php`, `supprimer.php`).

## Étape 4 — La protection CSRF (`CsrfHelper.php`)

Le jeton et sa vérification (module 02.6) sont isolés dans une classe dédiée plutôt que dupliqués dans chaque page. `CsrfHelper::exigerJetonValide()` est appelée en tout début de traitement de **chaque** formulaire POST du projet (connexion, création, modification, suppression) — aucune action qui modifie des données n'échappe à cette vérification.

## Étape 5 — Le CRUD avec tri/filtre/recherche (`TacheRepository.php`)

Reprend directement la structure du [module 02.9](../09-crud-complet-pdo-tri-filtre-recherche/README.md), avec un ajout important : **chaque méthode reçoit `utilisateurId` et l'inclut dans sa clause `WHERE`**. Ce n'est pas une option — c'est ce qui garantit qu'un utilisateur connecté ne peut jamais lire, modifier ou supprimer les tâches d'un autre, même en modifiant manuellement l'`id` dans l'URL (`modifier.php?id=42`) : si la tâche 42 n'appartient pas à l'utilisateur courant, `trouver()` renvoie `null` et la page répond 404.

## Étape 6 — Les pages web (`public/`)

Chaque page suit le même squelette : `session_start()` → inclusion des classes nécessaires → `Auth::exigerConnexion()` → logique de la page → affichage HTML avec `htmlspecialchars()` systématique sur toute donnée affichée. `index.php` est la page la plus dense : elle lit les paramètres `?tri=`, `?ordre=`, `?recherche=`, `?statut=`, `?page=` depuis l'URL et les transmet à `TacheRepository::lister()`, exactement comme décrit dans l'exemple d'utilisation du module 02.9.

## Pour aller plus loin (hors scope de ce mini-projet)

Ce projet n'utilise pas encore Composer/autoloading (module 02.7 vu en théorie, mais pas appliqué ici) : chaque fichier est inclus manuellement avec `require_once`, pour bien voir cette mécanique une dernière fois avant qu'elle ne soit automatisée dès le [Niveau 03](../../03-php-avance/README.md). Il n'y a pas non plus de tests automatisés (arrivent au [module 03.3](../../03-php-avance/03-tests-unitaires-phpunit/README.md)) ni de pagination "intelligente" (affichage tronqué pour de nombreuses pages) — volontairement simplifié pour rester centré sur les objectifs du niveau 02.
