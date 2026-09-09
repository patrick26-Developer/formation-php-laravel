# Solutions — 08.1 Jobs, Queues, Events, Listeners

## Exercise 1

```php
class GenererRapportSimple implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        sleep(3);
        logger('Report generated.');
    }
}
```
```php
GenererRapportSimple::dispatch();
```
```bash
php artisan queue:work
```
The HTTP request that triggered `dispatch()` responds immediately; the
"Report generated." message only appears in the logs 3 seconds later,
processed by the worker in the background.

## Exercise 2

```php
class GenererRapportSimple implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function handle(): void
    {
        if (random_int(0, 1) === 0) {
            throw new \RuntimeException('Simulated failure.');
        }
        logger('Report generated successfully.');
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Final failure after 3 attempts: ' . $exception->getMessage());
    }
}
```

## Exercise 3

```php
class EnvoyerNotificationMessage implements ShouldQueue
{
    use Queueable;

    public function __construct(public Message $message) {}

    public function handle(): void
    {
        $this->message->annonce->user->notify(new NouveauMessageNotification($this->message));
    }
}
```
```php
// MessageController::store()
$message = $annonce->messages()->create($data);
EnvoyerNotificationMessage::dispatch($message);
```

## Exercise 4

```php
class AnnonceCree
{
    use Dispatchable;
    public function __construct(public Annonce $annonce) {}
}

class NotifierBienvenueVendeur
{
    public function handle(AnnonceCree $event): void
    {
        // confirmation notification to the seller
    }
}

class JournaliserCreationAnnonce
{
    public function handle(AnnonceCree $event): void
    {
        logger("New listing created: {$event->annonce->titre}");
    }
}
```
```php
// AnnonceController::store()
$annonce = Annonce::create($data);
AnnonceCree::dispatch($annonce);
```

## Exercise 5

```php
class NotifierBienvenueVendeur implements ShouldQueue
{
    public function handle(AnnonceCree $event): void { /* ... */ }
}
// JournaliserCreationAnnonce stays synchronous (no ShouldQueue)
```
With `QUEUE_CONNECTION=sync`: both Listeners run immediately, in the
same process, like normal PHP code — convenient for development/testing
since no worker is needed and the behavior is immediately observable.

With `QUEUE_CONNECTION=database`: `JournaliserCreationAnnonce` runs
immediately, but `NotifierBienvenueVendeur` is placed in the queue and
only processed once an active `queue:work` picks it up — if no worker
is running, this Listener NEVER runs, staying indefinitely pending in
the `jobs` table.

`sync` is reserved for development/testing precisely because it hides
real production behavior: a genuinely slow task run in `sync` would
block the HTTP response exactly as if there were no queue at all,
defeating the whole point of the mechanism.
