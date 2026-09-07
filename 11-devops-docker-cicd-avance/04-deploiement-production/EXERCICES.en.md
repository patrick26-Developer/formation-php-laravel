# Exercises — 11.4 Production Deployment

## Exercise 1 — Comparing hosting options (easy)

For each of these projects, choose the lesson's most suitable hosting option and justify it in one sentence: (a) the level 06 mini-project for your personal portfolio, (b) a startup with unpredictable traffic that sometimes doubles overnight, (c) an agency managing 15 similar Laravel client sites.

## Exercise 2 — Configuring Supervisor (easy)

On a VM/container with Laravel installed, configure Supervisor to keep 2 queue workers active. Manually kill a worker process (`kill -9`) and verify it restarts automatically.

## Exercise 3 — Simulating a zero-downtime deployment (medium)

With two versions of a Docker container (v1 displaying "Version 1", v2 displaying "Version 2"), configure Nginx to switch instantly from one version to the other by changing its `upstream` configuration then reloading Nginx (`nginx -s reload`, with no full restart). Verify no request fails during the switch.

## Exercise 4 — Splitting a destructive migration (medium)

Simulate renaming a `nom` column to `nom_complet` on `users` in a zero-downtime way: (1) add `nom_complet` without removing `nom`, duplicate the value; (2) deploy code reading `nom_complet`; (3) only in a later deployment, drop `nom`. Document these 3 steps in a `MIGRATION-SANS-COUPURE.md` file.

## Exercise 5 — Complete deployment pipeline (hard)

Extend module 11.3's exercise 5 CD workflow with a `deployer` job using `appleboy/ssh-action`. Configure the necessary secrets (use a test VM if possible). Verify a push to `main` automatically triggers build → image push → deployment → migrations → `optimize`, with no manual intervention.

---

See [solutions/README.md](solutions/README.md) for the answer key.
