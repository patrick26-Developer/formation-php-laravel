# 11.2 — Multiple Environments (Dev/Staging/Prod)

> **Status:** ✅ Available

## 🎯 Objectives

- Understand each environment's role in a professional development cycle.
- Structure `.env` files per environment without duplicating secrets.
- Adapt `docker-compose` for development and production.
- Manage migrations safely across environments.

## 📋 Prerequisites

[11.1 — Fully Dockerizing a Laravel Application](../01-dockerisation-application-laravel-complete/README.en.md), [06.1 — Installing Laravel](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Why several environments?

| Environment | Role | Who accesses it |
|---|---|---|
| **Development (local)** | Coding and testing locally, fake data | Developers only |
| **Staging** | Validate before production, under near-real conditions | Team + stakeholders (acceptance testing) |
| **Production** | The real end users | Everyone (public) |

> ⚠️ **Never test a risky feature directly in production.** Staging exists precisely to catch problems (a bug, a performance regression, a migration error) **before** they affect real users — a principle already applied implicitly to automated tests (module 08.3), extended here to the infrastructure itself.

### `APP_ENV`: the variable that drives Laravel's behavior

```
# .env (development)
APP_ENV=local
APP_DEBUG=true      # shows detailed errors, useful in development

# .env (production)
APP_ENV=production
APP_DEBUG=false      # NEVER true in production (a reminder from modules 06.1 and 09.6)
```

> 📌 `APP_DEBUG=true` in production is one of the **most common and most serious** configuration mistakes: it exposes the full stack trace (server paths, SQL queries, sometimes credentials) to the first visitor who triggers an error.

### Docker Compose per environment: separate files, not one file with `if`s

```
docker-compose.yml           # common base (services, networks)
docker-compose.override.yml   # AUTOMATIC override in development (mounted volumes, hot-reload)
docker-compose.prod.yml         # EXPLICIT override in production (no code volumes, restart policy)
```

```bash
# Development: docker-compose.yml + docker-compose.override.yml merged AUTOMATICALLY
docker compose up

# Production: EXPLICIT merge with the prod file
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

```yaml
# docker-compose.override.yml (dev)
services:
  app:
    volumes:
      - .:/var/www/html   # code mounted live: editing a local file shows up immediately
    environment:
      APP_ENV: local

# docker-compose.prod.yml
services:
  app:
    restart: unless-stopped   # restarts automatically on crash
    # NO code volume: the image already contains everything, immutable
```

> 💡 In development, the source code is **mounted** (changes are immediate, no image rebuild needed); in production, the image is **immutable** — it contains a frozen version of the code, deployed via a full rebuild on every update (module 11.3), never modified "on the fly".

### Managing migrations across environments

```bash
# Development: freely, including migrate:fresh (data loss acceptable)
php artisan migrate:fresh --seed

# Staging/Production: NEVER migrate:fresh (would delete real data)
php artisan migrate --force   # --force needed because Laravel asks for confirmation in a non-local environment
```

> ⚠️ `migrate:fresh` in production is a potential disaster: it **drops every table** before replaying migrations. Laravel refuses to run `migrate` without confirmation in a non-local environment, precisely to prevent this kind of mistake — `--force` bypasses this protection and must be reserved for a trusted automated pipeline (module 11.3), never typed "by hand" in a rush.

## ✅ Key takeaways

- Staging exists to catch problems before they reach production, never to be skipped to save time.
- `APP_DEBUG=false` is non-negotiable in production.
- Separate Docker Compose files per environment beat a single file with complex conditions.
- `migrate:fresh` must never run in staging/production; `migrate --force` stays reserved for a trusted pipeline.

## ➡️ Going further

- [laravel.com/docs — Configuration (Environment Configuration)](https://laravel.com/docs/configuration#environment-configuration)
- [docs.docker.com/compose — Multiple Compose files](https://docs.docker.com/compose/multiple-compose-files/)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [11.1 — Full Dockerization](../01-dockerisation-application-laravel-complete/README.en.md) · **Next:** [11.3 — Complete CI/CD Pipeline](../03-pipeline-cicd-github-actions-laravel/README.md) *(French only)*
