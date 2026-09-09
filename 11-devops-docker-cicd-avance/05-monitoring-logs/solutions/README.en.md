# Solutions — 11.5 Monitoring and Log Management

## Exercise 1

```php
public function store(StoreAnnonceRequest $request): RedirectResponse
{
    $data = $request->validated();
    $data['user_id'] = $request->user()->id;
    $annonce = Annonce::create($data);

    logger()->info('New listing created', [
        'user_id' => $request->user()->id,
        'annonce_id' => $annonce->id,
    ]);

    return redirect()->route('annonces.show', $annonce);
}
```

## Exercise 2

```php
// config/logging.php
'channels' => [
    'stack' => ['driver' => 'stack', 'channels' => ['single', 'daily']],
    'single' => ['driver' => 'single', 'path' => storage_path('logs/laravel.log')],
    'daily' => ['driver' => 'daily', 'path' => storage_path('logs/laravel.log'), 'days' => 14],
],
```
```bash
# .env
LOG_CHANNEL=stack
```
After a `logger()->info('test')`, the message appears in `laravel.log`
AND in `laravel-2026-09-06.log` (the daily file).

## Exercise 3

```php
'critique' => [
    'driver' => 'single',
    'path' => storage_path('logs/critique.log'),
    'level' => 'error',
],
```
```php
logger('critique')->debug('ignored');
logger('critique')->info('ignored');
logger('critique')->error('appears in critique.log');
```
Only the `error` message appears in `critique.log`: `debug` and `info`
are below the configured threshold.

## Exercise 4

```php
// routes/web.php or Laravel 11+ config
use Illuminate\Support\Facades\DB;

Route::get('/up', function () {
    try {
        DB::connection()->getPdo();
        return response('OK', 200);
    } catch (\Throwable $e) {
        return response('Database unreachable', 503);
    }
});
```
With a wrong `DB_PASSWORD` in `.env`: `/up` correctly returns 503,
clearly flagging the problem to any external monitoring system.

## Exercise 5

```markdown
# POSTMORTEM.md — Notifications not sent for 2 hours

## Notice
2:32pm: several users report not receiving notifications for new
messages on their listings. No automatic alert had fired (no
healthcheck on the worker itself).

## Diagnosis
`supervisorctl status` reveals that `laravel-worker:laravel-worker_00`
has been in FATAL state since 12:41pm (2h51 earlier): the process had
crashed following a memory error (PHP Fatal error: Allowed memory size
exhausted) on a Job processing an unusually large batch, and Supervisor
had reached its automatic restart attempt limit (startretries).

## Containment
Immediate manual restart: `supervisorctl start laravel-worker:*`.
Jobs accumulated in the `jobs` table (database driver) started being
processed immediately after.

## Fix
- Increased the PHP memory limit specifically for workers
  (a higher `memory_limit` than for the web server).
- Increased Supervisor's `startretries`, AND added a dedicated Slack
  alert on the `critical` channel if a worker stays in FATAL state.
- Added a test reproducing a Job with a large dataset, verifying it
  processes without a memory overflow.

## Documentation
This post-mortem is shared with the team. Follow-up action: add a
healthcheck specific to the worker (not just the web application),
missing until now and identified as the cause of the 2-hour detection delay.
```
