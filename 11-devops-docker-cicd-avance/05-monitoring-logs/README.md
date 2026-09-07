# 11.5 — Monitoring et gestion des logs

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Configurer les canaux de logs Laravel adaptés à la production.
- Journaliser efficacement les informations utiles au diagnostic.
- Mettre en place une supervision applicative basique (uptime, erreurs).
- Réagir méthodiquement à un incident en production.

## 📋 Prérequis

[11.4 — Déploiement en production](../04-deploiement-production/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Les canaux de logs Laravel

```php
// config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'slack'], // envoie vers PLUSIEURS canaux à la fois
    ],
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
    ],
    'slack' => [
        'driver' => 'slack',
        'url' => env('LOG_SLACK_WEBHOOK_URL'),
        'level' => 'error', // seuls les logs de niveau "error" ou plus grave y sont envoyés
    ],
],
```

> 💡 Un canal `stack` envoie **simultanément** vers plusieurs destinations : les logs de fichier (pour l'historique complet) **et** une alerte Slack (uniquement pour les erreurs critiques, pour ne pas noyer l'équipe sous des notifications). Dans un conteneur Docker (module 11.1), le canal recommandé est souvent `stderr` : les logs partent vers la sortie standard du conteneur, collectée automatiquement par l'outillage Docker/Kubernetes environnant.

### Les niveaux de log, du moins au plus grave

```php
logger()->debug('Détail technique utile en développement uniquement');
logger()->info('Un utilisateur s\'est connecté');
logger()->warning('Tentative de connexion avec un compte verrouillé');
logger()->error('Échec de l\'envoi d\'un email de notification');
logger()->critical('La base de données ne répond plus');
```

> 📌 Chaque canal peut filtrer par niveau minimal (`'level' => 'error'` dans l'exemple Slack ci-dessus) — évitant de recevoir une alerte Slack pour chaque `debug()`, réservée aux problèmes réellement actionnables.

### Journaliser avec contexte, pas juste un message

```php
// ❌ Peu utile pour diagnostiquer
logger()->error('Erreur lors de la création de l\'annonce');

// ✅ Contexte suffisant pour comprendre SANS avoir à reproduire le bug
logger()->error('Échec de création d\'annonce', [
    'user_id' => $request->user()->id,
    'donnees' => $request->except(['password']), // jamais de données sensibles dans un log
    'erreur' => $exception->getMessage(),
]);
```

> ⚠️ **Ne jamais journaliser de données sensibles** (mots de passe, jetons, numéros de carte bancaire) : les logs sont souvent moins protégés que la base de données elle-même, et peuvent être consultés par plus de personnes (équipe support, outils de monitoring tiers).

### Monitoring applicatif : au-delà des logs

| Outil/pratique | Ce qu'il surveille |
|---|---|
| **Healthcheck HTTP** (`/up` en Laravel 11+) | L'application répond-elle et sa base de données est-elle accessible ? |
| **Uptime monitoring** (UptimeRobot, Better Uptime...) | Le site est-il accessible depuis l'extérieur, en continu ? |
| **Error tracking** (Sentry, Flare) | Centralise et regroupe les exceptions similaires, avec stack trace complète |
| **APM** (Application Performance Monitoring, ex : Laravel Telescope en dev, Datadog en prod) | Temps de réponse, requêtes lentes, goulots d'étranglement |

```php
// routes/web.php (Laravel 11+, healthcheck intégré)
// GET /up retourne 200 si l'application démarre correctement
```

> 💡 Un healthcheck (`/up`) est **essentiel** pour un déploiement zéro-downtime (module 11.4) : le reverse proxy ou l'orchestrateur ne bascule le trafic vers la nouvelle version qu'après confirmation que ce endpoint répond correctement.

### Réagir à un incident : une méthode, pas de la panique

1. **Constater** : le healthcheck ou l'alerte Slack signale un problème.
2. **Diagnostiquer** : consulter `storage/logs/laravel.log` (ou l'outil d'error tracking) pour identifier l'exception exacte et son contexte.
3. **Contenir** : si nécessaire, revenir à la version précédente (rollback via le tag Docker par SHA, module 11.3) plutôt que de tenter un correctif en urgence sous pression.
4. **Corriger** : traiter la cause racine dans une branche dédiée, avec un test qui reproduit le bug (module 08.3) avant de le corriger.
5. **Documenter** : un court post-mortem (qu'est-ce qui s'est passé, pourquoi, comment l'éviter) profite à toute l'équipe pour l'avenir.

## ✅ Points clés à retenir

- Un canal `stack` combine plusieurs destinations de logs ; filtrer par niveau évite le bruit inutile.
- Toujours journaliser avec du contexte exploitable, jamais de données sensibles.
- Un healthcheck HTTP est la base de tout monitoring et de tout déploiement zéro-downtime automatisé.
- En cas d'incident : constater, diagnostiquer, contenir (rollback si besoin), corriger avec un test, documenter.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Logging](https://laravel.com/docs/logging)
- [flareapp.io](https://flareapp.io/) / [sentry.io](https://sentry.io/)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [11.4 — Déploiement en production](../04-deploiement-production/README.md) · **Suite :** [Niveau 12 — Projets sans base de données](../../12-projets-sans-base-de-donnees/README.md)
