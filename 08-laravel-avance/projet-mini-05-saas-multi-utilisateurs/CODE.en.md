# Complete Source Code

This project's entire code already exists in this repository — click a file to open it, copy it as-is into your own Laravel project by following [INSTALLATION.md](INSTALLATION.en.md).

## `app/Contracts`

- [app/Contracts/RapportGenerator.php](app/Contracts/RapportGenerator.php)

## `app/Http/Controllers`

- [app/Http/Controllers/ProjectController.php](app/Http/Controllers/ProjectController.php)

## `app/Jobs`

- [app/Jobs/GenererRapportHebdomadaire.php](app/Jobs/GenererRapportHebdomadaire.php)

## `app/Models`

- [app/Models/Project.php](app/Models/Project.php)
- [app/Models/Task.php](app/Models/Task.php)
- [app/Models/Tenant.php](app/Models/Tenant.php)
- [app/Models/User-additions.php](app/Models/User-additions.php)

## `app/Policies`

- [app/Policies/ProjectPolicy.php](app/Policies/ProjectPolicy.php)

## `app/Providers`

- [app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php)

## `app/Services`

- [app/Services/RapportHebdomadaireGenerator.php](app/Services/RapportHebdomadaireGenerator.php)

## `database/factories`

- [database/factories/ProjectFactory.php](database/factories/ProjectFactory.php)
- [database/factories/TaskFactory.php](database/factories/TaskFactory.php)
- [database/factories/TenantFactory.php](database/factories/TenantFactory.php)

## `database/migrations`

- [database/migrations/2024_03_01_000001_create_tenants_table.php](database/migrations/2024_03_01_000001_create_tenants_table.php)
- [database/migrations/2024_03_01_000002_add_tenant_id_to_users_table.php](database/migrations/2024_03_01_000002_add_tenant_id_to_users_table.php)
- [database/migrations/2024_03_01_000003_create_projects_table.php](database/migrations/2024_03_01_000003_create_projects_table.php)
- [database/migrations/2024_03_01_000004_create_tasks_table.php](database/migrations/2024_03_01_000004_create_tasks_table.php)

## `database/seeders`

- [database/seeders/SaasSeeder.php](database/seeders/SaasSeeder.php)

## `resources/views/projects`

- [resources/views/projects/index.blade.php](resources/views/projects/index.blade.php)
- [resources/views/projects/show.blade.php](resources/views/projects/show.blade.php)

## `routes`

- [routes/web.php](routes/web.php)

## `tests/Feature`

- [tests/Feature/IsolationTenantTest.php](tests/Feature/IsolationTenantTest.php)
- [tests/Feature/RapportJobTest.php](tests/Feature/RapportJobTest.php)

---

Back to the [project README](README.en.md).
