# Exercices — 11.5 Monitoring et gestion des logs

## Exercice 1 — Journaliser avec contexte (facile)

Sur le [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md), ajoutez un `logger()->info()` avec contexte (`user_id`, `annonce_id`) dans `AnnonceController::store()`. Inspectez `storage/logs/laravel.log`.

## Exercice 2 — Canal stack (facile)

Configurez un canal `stack` combinant `single` et un second canal `daily` (rotation quotidienne des fichiers). Vérifiez qu'un log apparaît dans les deux destinations.

## Exercice 3 — Filtrer par niveau (moyen)

Configurez un canal fictif "critique" ne loggant que `error` et au-dessus. Envoyez un `debug()`, un `info()`, et un `error()` : vérifiez qu'un seul apparaît dans ce canal.

## Exercice 4 — Healthcheck personnalisé (moyen)

Créez une route `/up` (ou vérifiez celle générée par défaut en Laravel 11+) qui teste aussi la connexion à la base de données (`DB::connection()->getPdo()`). Simulez une base injoignable (mauvais identifiants) et vérifiez que le healthcheck échoue correctement.

## Exercice 5 — Simuler un incident complet (difficile)

Rédigez un post-mortem fictif (`POSTMORTEM.md`) suivant la méthode du cours pour un incident inventé (ex : "le worker de queue s'est arrêté silencieusement pendant 2 heures, les notifications n'étaient plus envoyées"). Couvrez les 5 étapes : constat, diagnostic, contention, correction, documentation — avec des détails techniques plausibles à chaque étape.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
