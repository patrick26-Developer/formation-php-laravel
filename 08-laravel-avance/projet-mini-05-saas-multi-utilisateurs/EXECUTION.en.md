# Running the Application

## Run the test suite (do this first)

```bash
php artisan test
```

`IsolationTenantTest` is this project's most important test: it
reproducibly proves that a user from one tenant can neither list nor
view another tenant's projects. It's the best entry point for
understanding this mini-project, even before launching the interface.

## Launch the application

```bash
php artisan serve
```

In a second terminal, start the worker so background reports get processed:
```bash
php artisan queue:work
```

## Using the application

1. Grab a user's email: `php artisan tinker` then `\App\Models\User::first()->email` (password: `password`).
2. Log in, look at the dashboard: active/total projects, filtered to your tenant only.
3. Create a project, click "Generate weekly report".
4. Check `storage/logs/laravel.log` (with the worker running): the report appears a moment later, processed in the background.

## Verifying isolation manually

Log in as a user from the "Acme Corp" tenant, note one of its project IDs in the URL. Log out, log in as a user from "Globex", and try to access `/projects/{that-id}` directly: Laravel must respond with **404** (the global scope makes the project unfindable for this tenant, even before any Policy check).

## Verifying the cache

With `DB::listen()` active (module 07.1), reload the dashboard several times: the statistics count query should only appear once every 10 minutes (the cache duration), not on every page load.

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
