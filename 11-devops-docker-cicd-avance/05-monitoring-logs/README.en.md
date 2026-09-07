# 11.5 — Monitoring and Log Management

> **Status:** ✅ Available

## 🎯 Objectives

- Configure Laravel logging channels suited to production.
- Log information effectively for diagnostics.
- Set up basic application monitoring (uptime, errors).
- React methodically to a production incident.

## 📋 Prerequisites

[11.4 — Production Deployment](../04-deploiement-production/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Laravel logging channels

```php
// config/logging.php
'channels' => [
    'stack' => [
        'driver' => 'stack',
        'channels' => ['single', 'slack'], // sends to SEVERAL channels at once
    ],
    'single' => [
        'driver' => 'single',
        'path' => storage_path('logs/laravel.log'),
    ],
    'slack' => [
        'driver' => 'slack',
        'url' => env('LOG_SLACK_WEBHOOK_URL'),
        'level' => 'error', // only "error" level or worse gets sent there
    ],
],
```

> 💡 A `stack` channel sends **simultaneously** to several destinations: file logs (for the complete history) **and** a Slack alert (only for critical errors, so the team isn't flooded with notifications). Inside a Docker container (module 11.1), the recommended channel is often `stderr`: logs go to the container's standard output, automatically collected by the surrounding Docker/Kubernetes tooling.

### Log levels, from least to most severe

```php
logger()->debug('Technical detail useful in development only');
logger()->info('A user logged in');
logger()->warning('Login attempt with a locked account');
logger()->error('Failed to send a notification email');
logger()->critical('The database is not responding');
```

> 📌 Each channel can filter by minimum level (`'level' => 'error'` in the Slack example above) — avoiding a Slack alert for every `debug()`, reserving alerts for genuinely actionable problems.

### Logging with context, not just a message

```php
// ❌ Not very useful for diagnosis
logger()->error('Error while creating the listing');

// ✅ Enough context to understand WITHOUT having to reproduce the bug
logger()->error('Failed to create listing', [
    'user_id' => $request->user()->id,
    'donnees' => $request->except(['password']), // never sensitive data in a log
    'erreur' => $exception->getMessage(),
]);
```

> ⚠️ **Never log sensitive data** (passwords, tokens, credit card numbers): logs are often less protected than the database itself, and can be seen by more people (support team, third-party monitoring tools).

### Application monitoring: beyond logs

| Tool/practice | What it monitors |
|---|---|
| **HTTP healthcheck** (`/up` in Laravel 11+) | Does the application respond, and is its database reachable? |
| **Uptime monitoring** (UptimeRobot, Better Uptime...) | Is the site reachable from the outside, continuously? |
| **Error tracking** (Sentry, Flare) | Centralizes and groups similar exceptions, with a full stack trace |
| **APM** (Application Performance Monitoring, e.g. Laravel Telescope in dev, Datadog in prod) | Response times, slow queries, bottlenecks |

```php
// routes/web.php (Laravel 11+, built-in healthcheck)
// GET /up returns 200 if the application starts correctly
```

> 💡 A healthcheck (`/up`) is **essential** for a zero-downtime deployment (module 11.4): the reverse proxy or orchestrator only switches traffic to the new version after confirming this endpoint responds correctly.

### Reacting to an incident: a method, not panic

1. **Notice**: the healthcheck or Slack alert flags a problem.
2. **Diagnose**: check `storage/logs/laravel.log` (or the error tracking tool) to identify the exact exception and its context.
3. **Contain**: if needed, roll back to the previous version (rollback via the Docker tag by SHA, module 11.3) rather than attempting an emergency fix under pressure.
4. **Fix**: address the root cause in a dedicated branch, with a test that reproduces the bug (module 08.3) before fixing it.
5. **Document**: a short post-mortem (what happened, why, how to prevent it) benefits the whole team going forward.

## ✅ Key takeaways

- A `stack` channel combines several log destinations; filtering by level avoids unnecessary noise.
- Always log with actionable context, never sensitive data.
- An HTTP healthcheck is the foundation of any monitoring and any automated zero-downtime deployment.
- In an incident: notice, diagnose, contain (rollback if needed), fix with a test, document.

## ➡️ Going further

- [laravel.com/docs — Logging](https://laravel.com/docs/logging)
- [flareapp.io](https://flareapp.io/) / [sentry.io](https://sentry.io/)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [11.4 — Production Deployment](../04-deploiement-production/README.en.md) · **Next:** [Level 12 — Projects Without a Database](../../12-projets-sans-base-de-donnees/README.en.md)
