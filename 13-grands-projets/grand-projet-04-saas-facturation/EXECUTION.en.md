# Running the Application

## Run the tests

```bash
php artisan test --filter=LimitePlanTest
php artisan test --filter=BillingServiceTest
```

## Launch the application

```bash
php artisan serve
```

Log in with `demo@acme.test` (password `password`), create projects until you hit the "Pro" plan's limit (20).

## Triggering billing manually

```bash
php artisan facturation:executer
```
```
1 subscription(s) to bill.
Tenant #1: invoice #1 — paid
```
*(Shows nothing if no subscription has reached its `fin_periode` — temporarily change the date in the database to test immediately.)*

## Testing the API

```bash
curl http://localhost:8000/api/v1/abonnement -H "Authorization: Bearer <token>"
curl http://localhost:8000/api/v1/factures -H "Authorization: Bearer <token>"
```

## Running with Docker and verifying the scheduler

```bash
docker compose up -d
docker compose logs -f scheduler
```
The `scheduler` container runs `php artisan schedule:work` continuously — the `facturation:executer` command triggers automatically every day at 3am (`routes/console.php`).

## Verifying the CI/CD pipeline

Push this project to a GitHub repository: the Actions tab automatically runs `.github/workflows/ci.yml` — migrations against an ephemeral MySQL, then `LimitePlanTest`/`BillingServiceTest`, then (on `main` only) building and pushing the Docker image.

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
