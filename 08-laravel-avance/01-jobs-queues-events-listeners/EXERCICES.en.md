# Exercises — 08.1 Jobs, Queues, Events, Listeners

## Exercise 1 — First Job (easy)

Create a `GenererRapportSimple` Job that simulates a long process (`sleep(3)`) then logs a message. Dispatch it and verify it runs via `queue:work` without blocking the page.

## Exercise 2 — Job with handled failure (easy)

Modify the Job to randomly throw an exception (1 chance in 2). Configure `$tries = 3` and a `failed()` method logging the final failure.

## Exercise 3 — Migrating the Level 07 notification into a Job (medium)

On the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md), create a Job `EnvoyerNotificationMessage` that wraps `$annonce->user->notify(...)`. Replace the direct call in `MessageController::store()` with `dispatch()`.

## Exercise 4 — Event and two Listeners (medium)

Create an Event `AnnonceCree` and two Listeners: one sending a welcome notification to the seller, the other simply logging the creation. Trigger the event in `AnnonceController::store()`.

## Exercise 5 — Asynchronous vs. synchronous Listener (hard)

Make one of exercise 4's two Listeners asynchronous (`ShouldQueue`) and leave the other synchronous. With `QUEUE_CONNECTION=sync` then `QUEUE_CONNECTION=database`, observe the difference in behavior (execution order, need for an active worker) and explain in a comment why `sync` is useful in development/testing but never in production for genuinely slow tasks.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
