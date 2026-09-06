# Journal de construction

## Étape 1 — Le socle Composer

Contrairement au mini-projet du niveau 02 (`require_once` manuels, volontairement), ce projet démarre directement avec un `composer.json` définissant l'autoload PSR-4 (`App\` → `src/`) — la mécanique du [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md) appliquée dès le départ, car un projet avec routeur/contrôleurs/modèles multiplie rapidement le nombre de classes.

## Étape 2 — Le noyau (`src/Core/`)

`Routeur.php` reprend l'implémentation du [module 03.2](../02-architecture-mvc-from-scratch/README.md), enrichie du support des middlewares (exercice 5 de ce même module) — même si ce projet ne les utilise pas activement, la possibilité est là pour, par exemple, protéger `/taches/creer` par une authentification dans une évolution future.

`Vue.php` reprend le mini-moteur de template à `extract()` du même module. `Reponse.php` centralise les helpers JSON du [module 03.4](../04-construction-api-rest-php-natif/README.md) (`json()`, `corpsJson()`), pour que les deux ne soient écrits qu'une seule fois et réutilisés par `TacheApiController`.

## Étape 3 — Le Modèle : un seul `TacheRepository` pour deux interfaces

C'est la décision d'architecture centrale de ce projet : `TacheRepository` (repris presque à l'identique du [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md)) ne sait **rien** de HTML ni de JSON. Il expose des méthodes qui retournent des tableaux PHP bruts (`creer()`, `trouver()`, `lister()`...). C'est aux **contrôleurs** de décider comment présenter ces données — HTML pour l'un, JSON pour l'autre.

## Étape 4 — Deux contrôleurs, une seule logique

`TacheWebController::liste()` et `TacheApiController::liste()` appellent tous les deux `$this->taches->lister(...)` avec les mêmes paramètres (tri, recherche, pagination) — la seule différence est ce qu'ils font du résultat : l'un le passe à `Vue::afficher()`, l'autre à `Reponse::json()`. Si un bug est corrigé dans `TacheRepository::lister()`, il est corrigé **simultanément** pour le web et l'API — la preuve concrète de l'intérêt de cette séparation, déjà entrevue au niveau 02.

## Étape 5 — Le front controller (`public/index.php`)

Toutes les routes (web et API) sont déclarées au même endroit, sur la même instance de `Routeur`. Ce fichier constitue la carte complète des URLs de l'application — exactement le rôle que joue `routes/web.php` (et `routes/api.php`) dans Laravel, vu au [module 06.2](../../06-laravel-fondamentaux/02-routing-controllers/README.md).

## Étape 6 — Les tests, sans dépendre de MySQL

Plutôt que de configurer une base MySQL de test (lente à réinitialiser entre chaque test, et qui rendrait les tests de ce projet dépendants d'un service externe), `tests/TacheRepositoryTest.php` utilise **SQLite en mémoire** (`new PDO('sqlite::memory:')`). Comme `TacheRepository` n'utilise que du SQL standard (aucune fonction propre à MySQL), il fonctionne identiquement sur les deux moteurs — un exemple concret de l'intérêt de PDO comme couche d'abstraction (vu au [module 02.8](../../02-php-intermediaire/08-pdo-bases-de-donnees-mysql/README.md)). Chaque test recrée une base fraîche dans `setUp()` : aucun test ne peut donc être affecté par les données laissées par un autre.

## Pour aller plus loin (hors scope de ce projet)

Ce mini-framework ne gère ni l'authentification, ni l'injection de dépendances automatique (un "conteneur de services", que Laravel appelle Service Container) — les contrôleurs sont instanciés manuellement dans `public/index.php`. C'est volontaire : comprendre ce câblage manuel une fois rend immédiatement compréhensible ce que Laravel automatise, dès le [Niveau 06](../../06-laravel-fondamentaux/README.md).
