# Solutions — 11.4 Déploiement en production

## Exercice 1

- (a) Portfolio personnel → **VPS manuel** : coût minimal, apprentissage maximal, trafic prévisible et faible.
- (b) Trafic imprévisible, pics soudains → **Laravel Vapor (serverless)** : scalabilité automatique sans intervention, on ne paie que ce qu'on consomme.
- (c) Agence, 15 sites similaires → **Laravel Forge** : automatise le provisionnement de serveurs répétitif, gain de temps considérable à cette échelle sans le coût opérationnel d'une équipe DevOps dédiée.

## Exercice 2

```ini
[program:laravel-worker]
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=2
```
```bash
supervisorctl update
supervisorctl status
# laravel-worker:laravel-worker_00   RUNNING
# laravel-worker:laravel-worker_01   RUNNING

kill -9 <PID_du_worker_00>
# Quelques secondes plus tard :
supervisorctl status
# laravel-worker:laravel-worker_00   RUNNING (nouveau PID)
```

## Exercice 3

```nginx
# nginx.conf
upstream app {
    server app_v1:9000;  # changé en "server app_v2:9000;" pour basculer
}
```
```bash
docker compose up -d app_v2       # démarre v2 EN PARALLÈLE de v1, toujours active
# Modifier nginx.conf : app_v1:9000 -> app_v2:9000
nginx -s reload                     # recharge la config SANS interrompre les connexions en cours
docker compose stop app_v1            # arrêt de l'ancienne version seulement après bascule confirmée
```
Un test de charge continu (`while true; do curl -s -o /dev/null -w "%{http_code}\n" http://localhost; sleep 0.1; done`)
pendant la bascule ne doit montrer aucune interruption (toujours 200).

## Exercice 4

```markdown
# MIGRATION-SANS-COUPURE.md

Étape 1 (déploiement A) : ajouter la colonne sans rien retirer
  Schema::table('users', fn ($t) => $t->string('nom_complet')->nullable());
  DB::table('users')->update(['nom_complet' => DB::raw('nom')]);
  -> Les DEUX versions du code (ancienne lisant "nom", nouvelle
     lisant "nom_complet") fonctionnent pendant cette fenêtre.

Étape 2 (déploiement B) : le code applicatif lit/écrit désormais
  "nom_complet" exclusivement. La colonne "nom" existe encore
  mais n'est plus utilisée par le code déployé.

Étape 3 (déploiement C, après confirmation que B est stable) :
  Schema::table('users', fn ($t) => $t->dropColumn('nom'));
  -> Sûr uniquement une fois certain qu'aucune ancienne instance
     du code (ex: un worker pas encore redémarré) n'y accède plus.
```

## Exercice 5

```yaml
  deployer:
    needs: build-et-push
    runs-on: ubuntu-latest
    steps:
      - uses: appleboy/ssh-action@v1
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
Testé : un `git push origin main` déclenche visiblement les trois jobs en
cascade dans l'onglet Actions (`qualite-et-tests` → `build-et-push` →
`deployer`), chacun conditionné à la réussite du précédent (`needs:`),
sans qu'aucune commande ne soit tapée manuellement sur le serveur.
