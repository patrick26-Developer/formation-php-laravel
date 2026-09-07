# 11.4 — Déploiement en production

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comparer les principales options d'hébergement pour Laravel.
- Comprendre le déroulement d'un déploiement zéro-downtime.
- Superviser les processus d'une application en production (queue workers).
- Automatiser un déploiement complet depuis GitHub Actions.

## 📋 Prérequis

[11.3 — Pipeline CI/CD complet](../03-pipeline-cicd-github-actions-laravel/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Les options d'hébergement pour Laravel

| Option | Niveau de contrôle | Effort opérationnel | Cas d'usage |
|---|---|---|---|
| **VPS manuel** (DigitalOcean, Hetzner...) | Total | Élevé (tout configurer soi-même) | Apprentissage, contrôle total, budget serré |
| **Laravel Forge** | Élevé | Faible (Forge automatise le serveur) | Projets pro sans équipe DevOps dédiée |
| **Laravel Vapor** (serverless AWS) | Moyen | Très faible | Trafic très variable, scalabilité automatique |
| **PaaS générique** (Railway, Render) | Moyen | Faible | Démarrage rapide, petits projets |

> 📌 Pour cette formation, le **VPS manuel avec Docker** (déjà construit au niveau 11.1) est le choix pédagogique recommandé : il force à comprendre **chaque couche** (serveur, reverse proxy, base de données, workers), une compréhension qui reste utile même en utilisant ensuite un service managé comme Forge.

### Superviser un worker de queue avec Supervisor

Rappel du [module 08.1](../../08-laravel-avance/01-jobs-queues-events-listeners/README.md) : `queue:work` doit tourner **en permanence**. Sur un serveur (hors Docker, ou à l'intérieur d'un conteneur qui l'exécute), **Supervisor** relance automatiquement le processus s'il s'arrête (crash, erreur mémoire).

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

> 💡 `numprocs=2` lance **2 workers en parallèle** — le même principe de scalabilité horizontale que `docker compose up --scale queue-worker=3` (module 11.1), appliqué ici sans Docker.

### Déploiement zéro-downtime : le principe

Un déploiement naïf (arrêter l'ancienne version, déployer la nouvelle, redémarrer) provoque une **coupure de service** pendant la transition. Le déploiement **zéro-downtime** évite cette coupure :

1. La nouvelle version est déployée dans un **nouveau** répertoire/conteneur, **en parallèle** de l'ancienne, toujours active.
2. Les migrations s'exécutent sur la nouvelle version (compatible avec l'ancienne le temps de la transition — attention aux migrations destructives, voir encadré).
3. Une fois la nouvelle version prête, le reverse proxy (Nginx) **bascule le trafic** instantanément vers elle.
4. L'ancienne version est arrêtée seulement après confirmation que la nouvelle fonctionne.

> ⚠️ **Une migration qui supprime une colonne encore utilisée par l'ancienne version** casserait celle-ci pendant la fenêtre de transition. La pratique professionnelle consiste à découper un tel changement en **plusieurs déploiements** : d'abord arrêter d'utiliser la colonne dans le code, déployer, **puis seulement ensuite** la supprimer dans une migration séparée.

### Automatiser le déploiement depuis GitHub Actions (suite du module 11.3)

```yaml
# .github/workflows/cd.yml (suite)
  deployer:
    needs: build-et-push
    runs-on: ubuntu-latest
    steps:
      - name: Déployer via SSH
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

> 📌 Ce job ne s'exécute **qu'après** `build-et-push` (`needs:`) : le déploiement d'une image qui n'a pas encore fini d'être construite et poussée n'aurait aucun sens. Rappel du [module 08.2](../../08-laravel-avance/02-cache-optimisation-performance/README.md) : `optimize` recrée les caches de configuration/routes/vues après chaque déploiement.

## ✅ Points clés à retenir

- Un VPS + Docker offre le meilleur compromis pédagogique : contrôle total et compréhension de chaque couche.
- Supervisor maintient les workers de queue actifs en permanence, avec relance automatique en cas de crash.
- Un déploiement zéro-downtime bascule le trafic seulement une fois la nouvelle version prête, jamais avant.
- Une migration destructive se découpe en plusieurs déploiements pour ne jamais casser la version encore active.

## ➡️ Pour aller plus loin

- [forge.laravel.com](https://forge.laravel.com/)
- [vapor.laravel.com](https://vapor.laravel.com/)
- [supervisord.org](http://supervisord.org/)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [11.3 — Pipeline CI/CD complet](../03-pipeline-cicd-github-actions-laravel/README.md) · **Suite :** [11.5 — Monitoring et gestion des logs](../05-monitoring-logs/README.md)
