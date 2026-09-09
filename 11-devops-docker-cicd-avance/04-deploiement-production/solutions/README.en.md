# Solutions — 11.4 Production Deployment

## Exercise 1

- (a) Personal portfolio → **Manual VPS**: minimal cost, maximum learning, predictable and low traffic.
- (b) Unpredictable traffic, sudden spikes → **Laravel Vapor (serverless)**: automatic scaling with no intervention, you only pay for what you use.
- (c) Agency, 15 similar sites → **Laravel Forge**: automates repetitive server provisioning, a considerable time saver at this scale without the operational cost of a dedicated DevOps team.

## Exercise 2

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

kill -9 <worker_00_PID>
# A few seconds later:
supervisorctl status
# laravel-worker:laravel-worker_00   RUNNING (new PID)
```

## Exercise 3

```nginx
# nginx.conf
upstream app {
    server app_v1:9000;  # changed to "server app_v2:9000;" to switch
}
```
```bash
docker compose up -d app_v2       # starts v2 IN PARALLEL with v1, still active
# Edit nginx.conf: app_v1:9000 -> app_v2:9000
nginx -s reload                     # reloads the config WITHOUT interrupting active connections
docker compose stop app_v1            # stop the old version only after the switch is confirmed
```
A continuous load test (`while true; do curl -s -o /dev/null -w "%{http_code}\n" http://localhost; sleep 0.1; done`)
during the switch should show no interruption at all (always 200).

## Exercise 4

```markdown
# MIGRATION-SANS-COUPURE.md

Step 1 (deployment A): add the column without removing anything
  Schema::table('users', fn ($t) => $t->string('nom_complet')->nullable());
  DB::table('users')->update(['nom_complet' => DB::raw('nom')]);
  -> BOTH versions of the code (the old one reading "nom", the new
     one reading "nom_complet") work during this window.

Step 2 (deployment B): the application code now reads/writes
  "nom_complet" exclusively. The "nom" column still exists but is
  no longer used by the deployed code.

Step 3 (deployment C, after confirming B is stable):
  Schema::table('users', fn ($t) => $t->dropColumn('nom'));
  -> Safe only once certain no old instance of the code (e.g., a
     worker not yet restarted) still accesses it.
```

## Exercise 5

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
Tested: a `git push origin main` visibly triggers all three jobs in a
cascade in the Actions tab (`qualite-et-tests` → `build-et-push` →
`deployer`), each conditioned on the previous one succeeding
(`needs:`), with no command typed manually on the server.
