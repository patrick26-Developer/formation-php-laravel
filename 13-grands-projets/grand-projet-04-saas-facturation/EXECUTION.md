# Exécution

## Lancer les tests

```bash
php artisan test --filter=LimitePlanTest
php artisan test --filter=BillingServiceTest
```

## Lancer l'application

```bash
php artisan serve
```

Connectez-vous avec `demo@acme.test` (mot de passe `password`), créez des projets jusqu'à atteindre la limite du plan "Pro" (20).

## Déclencher la facturation manuellement

```bash
php artisan facturation:executer
```
```
1 abonnement(s) à facturer.
Tenant #1 : facture #1 — payee
```
*(N'affiche rien si aucun abonnement n'a atteint sa `fin_periode` — modifiez temporairement la date en base pour tester immédiatement.)*

## Tester l'API

```bash
curl http://localhost:8000/api/v1/abonnement -H "Authorization: Bearer <token>"
curl http://localhost:8000/api/v1/factures -H "Authorization: Bearer <token>"
```

## Exécuter avec Docker et vérifier le scheduler

```bash
docker compose up -d
docker compose logs -f scheduler
```
Le conteneur `scheduler` exécute `php artisan schedule:work` en continu — la commande `facturation:executer` se déclenche automatiquement chaque jour à 3h (`routes/console.php`).

## Vérifier le pipeline CI/CD

Poussez ce projet sur un dépôt GitHub : l'onglet Actions exécute automatiquement `.github/workflows/ci.yml` — migrations sur MySQL éphémère, puis `LimitePlanTest`/`BillingServiceTest`, puis (sur `main` uniquement) build et push de l'image Docker.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
