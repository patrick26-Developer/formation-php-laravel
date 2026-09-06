# Exercices — 08.1 Jobs, Queues, Events, Listeners

## Exercice 1 — Premier Job (facile)

Créez un Job `GenererRapportSimple` qui simule un traitement long (`sleep(3)`) puis journalise un message. Distribuez-le et vérifiez qu'il s'exécute via `queue:work` sans bloquer la page.

## Exercice 2 — Job avec échec géré (facile)

Modifiez le Job pour lever une exception aléatoirement (1 chance sur 2). Configurez `$tries = 3` et une méthode `failed()` journalisant l'échec définitif.

## Exercice 3 — Migrer la notification du niveau 07 en Job (moyen)

Sur le [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md), créez un Job `EnvoyerNotificationMessage` qui encapsule `$annonce->user->notify(...)`. Remplacez l'appel direct dans `MessageController::store()` par `dispatch()`.

## Exercice 4 — Event et deux Listeners (moyen)

Créez un Event `AnnonceCree` et deux Listeners : un envoyant une notification de bienvenue au vendeur, l'autre journalisant simplement la création. Déclenchez l'event dans `AnnonceController::store()`.

## Exercice 5 — Listener asynchrone vs synchrone (difficile)

Rendez un des deux Listeners de l'exercice 4 asynchrone (`ShouldQueue`) et laissez l'autre synchrone. Avec `QUEUE_CONNECTION=sync` puis `QUEUE_CONNECTION=database`, observez la différence de comportement (ordre d'exécution, nécessité d'un worker actif) et expliquez en commentaire pourquoi `sync` est utile en développement/tests mais jamais en production pour de vraies tâches lentes.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
