# 08.1 — Jobs, Queues, Events, Listeners

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the value of asynchronous processing.
- Create and dispatch a Job to a queue.
- Configure a queue driver and run a worker.
- Decouple code with Events and Listeners.

## 📋 Prerequisites

[Level 07 — Intermediate Laravel](../../07-laravel-intermediaire/README.en.md), especially [07.7 — Notifications](../../07-laravel-intermediaire/07-notifications-mail/README.en.md)

## ⏱️ Estimated duration

2h30.

## 📖 Theory

### The problem: slow tasks block the HTTP response

In the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md), sending an email (`$annonce->user->notify(...)`) happens **during** the HTTP request handling: the user sending a message waits for the email to actually go out (connecting to the SMTP server, potentially 1 to 3 seconds) before receiving their confirmation page. For slow operations (email, PDF generation, calling an external API, image processing), this work is **deferred** to **after** the response, via a queue.

### Creating and dispatching a Job

```bash
php artisan make:job EnvoyerNotificationMessage
```

```php
// app/Jobs/EnvoyerNotificationMessage.php
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
// In the controller, instead of executing directly:
EnvoyerNotificationMessage::dispatch($message);
```

> 💡 `dispatch()` places the Job into a queue **immediately** (a few milliseconds) and the HTTP response goes out without waiting for the email to actually be sent — handled **separately**, by a dedicated process (the "worker").

### Configuring and running a worker

```
# .env
QUEUE_CONNECTION=database   # or "redis" in production for better performance
```

```bash
php artisan queue:table   # generates the migration for the "jobs" table (database driver)
php artisan migrate

php artisan queue:work     # starts a worker: processes jobs continuously
```

> ⚠️ **In production, `queue:work` must run permanently** (via a process supervisor like Supervisor, covered in depth in [module 11.4](../../11-devops-docker-cicd-avance/04-deploiement-production/README.md)) — if the worker stops, jobs pile up in the queue without being processed.

### Handling failures

```php
class EnvoyerNotificationMessage implements ShouldQueue
{
    public int $tries = 3;           // number of attempts before giving up
    public int $backoff = 30;          // seconds to wait between each attempt

    public function failed(\Throwable $exception): void
    {
        logger()->error('Final failure sending notification', ['error' => $exception->getMessage()]);
    }
}
```

### Events and Listeners: decoupling actions tied to the same trigger

An **Event** represents "something happened"; one or more **Listeners** react to it, without the code that triggers the event needing to know about them.

```bash
php artisan make:event MessageEnvoye
php artisan make:listener EnvoyerNotificationVendeur --event=MessageEnvoye
php artisan make:listener JournaliserMessage --event=MessageEnvoye
```

```php
// app/Events/MessageEnvoye.php
class MessageEnvoye
{
    use Dispatchable;

    public function __construct(public Message $message) {}
}
```

```php
// app/Listeners/EnvoyerNotificationVendeur.php
class EnvoyerNotificationVendeur implements ShouldQueue // a Listener can itself be queued
{
    public function handle(MessageEnvoye $event): void
    {
        $event->message->annonce->user->notify(new NouveauMessageNotification($event->message));
    }
}
```

```php
// In the controller: a single trigger, potentially several reactions
MessageEnvoye::dispatch($message);
```

> 📌 This is the **Observer** pattern from [module 03.1](../../03-php-avance/01-design-patterns-php/README.en.md), automated by Laravel: `GestionnaireCommande` and its `Observateur` become `MessageEnvoye` and its `Listener`s here. The advantage over writing everything in the controller: adding a new reaction (for example, also logging the message) requires **no change** to the controller, only a new registered Listener.

## ✅ Key takeaways

- `ShouldQueue` + `dispatch()` defers a slow task to asynchronous processing, without blocking the HTTP response.
- A worker (`queue:work`) must run continuously to process the queue; must be supervised in production.
- Events and Listeners automate the Observer pattern (module 03.1): one trigger, several decoupled reactions.
- A Listener can itself implement `ShouldQueue` to be processed asynchronously.

## ➡️ Going further

- [laravel.com/docs — Queues](https://laravel.com/docs/queues)
- [laravel.com/docs — Events](https://laravel.com/docs/events)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [Level 07 — Intermediate Laravel](../../07-laravel-intermediaire/README.en.md) · **Next:** [08.2 — Cache and Performance Optimization](../02-cache-optimisation-performance/README.en.md)
