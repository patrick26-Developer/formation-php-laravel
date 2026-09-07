# 11.2 — Environnements multiples (dev/staging/prod)

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le rôle de chaque environnement dans un cycle de développement professionnel.
- Structurer les fichiers `.env` par environnement sans dupliquer de secrets.
- Adapter `docker-compose` pour développement et production.
- Gérer les migrations de façon sûre entre environnements.

## 📋 Prérequis

[11.1 — Dockerisation complète d'une application Laravel](../01-dockerisation-application-laravel-complete/README.md), [06.1 — Installation de Laravel](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Pourquoi plusieurs environnements ?

| Environnement | Rôle | Qui y accède |
|---|---|---|
| **Développement (local)** | Coder et tester localement, données factices | Développeurs uniquement |
| **Staging (recette)** | Valider avant production, dans des conditions proches du réel | Équipe + parties prenantes (recette fonctionnelle) |
| **Production** | Les vrais utilisateurs finaux | Tout le monde (public) |

> ⚠️ **Ne jamais tester une fonctionnalité risquée directement en production.** Le staging existe précisément pour détecter les problèmes (bug, régression de performance, erreur de migration) **avant** qu'ils n'affectent de vrais utilisateurs — un principe déjà appliqué implicitement aux tests automatisés (module 08.3), étendu ici à l'infrastructure elle-même.

### `APP_ENV` : la variable qui pilote le comportement de Laravel

```
# .env (développement)
APP_ENV=local
APP_DEBUG=true      # affiche les erreurs détaillées, utile en développement

# .env (production)
APP_ENV=production
APP_DEBUG=false      # JAMAIS true en production (rappel du module 06.1 et 09.6)
```

> 📌 `APP_DEBUG=true` en production est l'une des erreurs de configuration les **plus fréquentes et les plus graves** : elle expose la stack trace complète (chemins serveur, requêtes SQL, parfois des identifiants) au premier visiteur qui provoque une erreur.

### Docker Compose par environnement : fichiers séparés, pas un seul fichier avec des `if`

```
docker-compose.yml           # base commune (services, réseaux)
docker-compose.override.yml   # surcharge AUTOMATIQUE en développement (volumes montés, hot-reload)
docker-compose.prod.yml         # surcharge explicite en production (pas de volumes de code, restart policy)
```

```bash
# Développement : docker-compose.yml + docker-compose.override.yml fusionnés AUTOMATIQUEMENT
docker compose up

# Production : fusion EXPLICITE avec le fichier de prod
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

```yaml
# docker-compose.override.yml (dev)
services:
  app:
    volumes:
      - .:/var/www/html   # code monté en live : modifier un fichier local se reflète immédiatement
    environment:
      APP_ENV: local

# docker-compose.prod.yml
services:
  app:
    restart: unless-stopped   # redémarre automatiquement en cas de crash
    # PAS de volume de code : l'image contient déjà tout, immuable
```

> 💡 En développement, on **monte** le code source (les modifications sont immédiates, sans reconstruire l'image) ; en production, l'image est **immuable** — elle contient une version figée du code, déployée par reconstruction complète à chaque mise à jour (module 11.3), jamais modifiée "à chaud".

### Gérer les migrations entre environnements

```bash
# Développement : librement, y compris migrate:fresh (perte de données acceptable)
php artisan migrate:fresh --seed

# Staging/Production : JAMAIS migrate:fresh (supprimerait les vraies données)
php artisan migrate --force   # --force nécessaire car Laravel demande confirmation en environnement non-local
```

> ⚠️ `migrate:fresh` en production est une catastrophe potentielle : elle **supprime toutes les tables** avant de rejouer les migrations. Laravel refuse d'exécuter `migrate` sans confirmation en environnement non-local, précisément pour éviter ce type d'erreur — `--force` outrepasse cette protection et doit être réservé à un pipeline automatisé de confiance (module 11.3), jamais tapé "à la main" sous le coup de la précipitation.

## ✅ Points clés à retenir

- Staging existe pour détecter les problèmes avant qu'ils n'atteignent la production, jamais à sauter par gain de temps.
- `APP_DEBUG=false` est non négociable en production.
- Des fichiers Docker Compose séparés par environnement valent mieux qu'un seul fichier avec des conditions complexes.
- `migrate:fresh` ne doit jamais s'exécuter en staging/production ; `migrate --force` reste réservé à un pipeline de confiance.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Configuration (Environment Configuration)](https://laravel.com/docs/configuration#environment-configuration)
- [docs.docker.com/compose — Multiple Compose files](https://docs.docker.com/compose/multiple-compose-files/)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [11.1 — Dockerisation complète](../01-dockerisation-application-laravel-complete/README.md) · **Suite :** [11.3 — Pipeline CI/CD complet](../03-pipeline-cicd-github-actions-laravel/README.md)
