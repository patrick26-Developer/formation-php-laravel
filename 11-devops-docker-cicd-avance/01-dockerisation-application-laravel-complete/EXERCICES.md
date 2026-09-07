# Exercices — 11.1 Dockerisation complète d'une application Laravel

## Exercice 1 — Construire l'image (facile)

Écrivez le Dockerfile multi-stage du cours pour le [mini-projet du niveau 06](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.md) (sans étape assets si pas de build front-end). Construisez l'image avec `docker build -t blog-laravel .`.

## Exercice 2 — Stack complète avec docker-compose (facile)

Écrivez un `docker-compose.yml` avec `app`, `nginx`, `mysql`. Lancez `docker compose up` et accédez à l'application sur `http://localhost:8000`.

## Exercice 3 — Ajouter Redis et un worker (moyen)

Ajoutez les services `redis` et `queue-worker` au compose du [mini-projet du niveau 08](../../08-laravel-avance/projet-mini-05-saas-multi-utilisateurs/README.md) (qui utilise déjà des Jobs). Vérifiez que le worker traite bien les jobs distribués par l'application.

## Exercice 4 — .dockerignore (moyen)

Construisez l'image SANS `.dockerignore`, inspectez sa taille (`docker images`) et son contenu (`docker run --rm image ls -la /var/www/html`). Ajoutez un `.dockerignore` complet, reconstruisez, comparez la taille et confirmez que `.env`/`.git` ne sont plus présents.

## Exercice 5 — Scaler les workers (difficile)

Avec le compose de l'exercice 3, lancez `docker compose up --scale queue-worker=3`. Distribuez 20 jobs simulant un traitement de 2 secondes chacun (`sleep(2)` dans le Job). Mesurez le temps total de traitement avec 1 worker puis avec 3 workers actifs, et expliquez en commentaire le gain observé.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
