# 11.4 — Production Deployment

> **Status:** ✅ Available

## 🎯 Objectives

- Compare the main hosting options for Laravel.
- Understand how a zero-downtime deployment unfolds.
- Supervise a production application's processes (queue workers).
- Automate a full deployment from GitHub Actions.

## 📋 Prerequisites

[11.3 — Complete CI/CD Pipeline](../03-pipeline-cicd-github-actions-laravel/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### Hosting options for Laravel

| Option | Level of control | Operational effort | Use case |
|---|---|---|---|
| **Manual VPS** (DigitalOcean, Hetzner...) | Total | High (configure everything yourself) | Learning, full control, tight budget |
| **Laravel Forge** | High | Low (Forge automates the server) | Professional projects with no dedicated DevOps team |
| **Laravel Vapor** (serverless AWS) | Medium | Very low | Highly variable traffic, automatic scaling |
| **Generic PaaS** (Railway, Render) | Medium | Low | Quick start, small projects |

> 📌 For this training, a **manual VPS with Docker** (already built in level 11.1) is the recommended pedagogical choice: it forces you to understand **every layer** (server, reverse proxy, database, workers) — an understanding that stays useful even after later switching to a managed service like Forge.

### Supervising a queue worker with Supervisor

A reminder from [module 08.1](../../08-laravel-avance/01-jobs-queues-events-listeners/README.en.md): `queue:work` must run **permanently**. On a server (outside Docker, or inside a container running it), **Supervisor** automatically restarts the process if it stops (crash, memory error).

```ini
; /etc/supervisor/conf.d/laravel-worker.conf
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/storage/logs/worker.log
```

```bash
supervisorctl reread
supervisorctl update
supervisorctl start laravel-worker:*
```

> 💡 `numprocs=2` launches **2 workers in parallel** — the same horizontal scaling principle as `docker compose up --scale queue-worker=3` (module 11.1), applied here without Docker.

### Zero-downtime deployment: the principle

A naive deployment (stop the old version, deploy the new one, restart) causes a **service outage** during the transition. **Zero-downtime** deployment avoids this outage:

1. The new version is deployed into a **new** directory/container, **in parallel** with the old one, which stays active.
2. Migrations run against the new version (compatible with the old one for the duration of the transition — watch out for destructive migrations, see the warning below).
3. Once the new version is ready, the reverse proxy (Nginx) **switches traffic** to it instantly.
4. The old version is stopped only after confirming the new one works.

> ⚠️ **A migration that drops a column still used by the old version** would break it during the transition window. Professional practice is to split such a change into **several deployments**: first stop using the column in the code, deploy, **and only then** drop it in a separate migration.

### Automating deployment from GitHub Actions (continuing module 11.3)

```yaml
# .github/workflows/cd.yml (continued)
  deployer:
    needs: build-et-push
    runs-on: ubuntu-latest
    steps:
      - name: Deploy via SSH
        uses: appleboy/ssh-action@v1
        with:
          host: ${{ secrets.SERVEUR_HOST }}
          username: ${{ secrets.SERVEUR_USER }}
          key: ${{ secrets.SERVEUR_SSH_KEY }}
          script: |
            cd /var/www/monapp
            docker compose pull
            docker compose up -d
            docker compose exec -T app php artisan migrate --force
            docker compose exec -T app php artisan optimize
```

> 📌 This job only runs **after** `build-et-push` (`needs:`): deploying an image that hasn't finished being built and pushed yet would make no sense. A reminder from [module 08.2](../../08-laravel-avance/02-cache-optimisation-performance/README.en.md): `optimize` rebuilds configuration/route/view caches after every deployment.

## ✅ Key takeaways

- A VPS + Docker offers the best pedagogical trade-off: full control and understanding of every layer.
- Supervisor keeps queue workers permanently active, with automatic restart on crash.
- A zero-downtime deployment switches traffic only once the new version is ready, never before.
- A destructive migration is split into several deployments so the still-active version never breaks.

## ➡️ Going further

- [forge.laravel.com](https://forge.laravel.com/)
- [vapor.laravel.com](https://vapor.laravel.com/)
- [supervisord.org](http://supervisord.org/)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [11.3 — Complete CI/CD Pipeline](../03-pipeline-cicd-github-actions-laravel/README.en.md) · **Next:** [11.5 — Monitoring and Log Management](../05-monitoring-logs/README.en.md)
