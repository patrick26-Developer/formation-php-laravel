# Solutions — 08.1 Jobs, Queues, Events, Listeners

## Exercice 1

```php
class GenererRapportSimple implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        sleep(3);
        logger('Rapport généré.');
    }
}
```
```php
GenererRapportSimple::dispatch();
```
```bash
php artisan queue:work
```
La requête HTTP qui a déclenché `dispatch()` répond immédiatement ; le
message "Rapport généré." n'apparaît dans les logs que 3 secondes plus
tard, traité par le worker en arrière-plan.

## Exercice 2

```php
class GenererRapportSimple implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public function handle(): void
    {
        if (random_int(0, 1) === 0) {
            throw new \RuntimeException('Échec simulé.');
        }
        logger('Rapport généré avec succès.');
    }

    public function failed(\Throwable $exception): void
    {
        logger()->error('Échec définitif après 3 tentatives : ' . $exception->getMessage());
    }
}
```

## Exercice 3

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

## Exercice 4

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
        // notification de confirmation au vendeur
    }
}

class JournaliserCreationAnnonce
{
    public function handle(AnnonceCree $event): void
    {
        logger("Nouvelle annonce créée : {$event->annonce->titre}");
    }
}
```
```php
// AnnonceController::store()
$annonce = Annonce::create($data);
AnnonceCree::dispatch($annonce);
```

## Exercice 5

```php
class NotifierBienvenueVendeur implements ShouldQueue
{
    public function handle(AnnonceCree $event): void { /* ... */ }
}
// JournaliserCreationAnnonce reste synchrone (pas de ShouldQueue)
```
Avec `QUEUE_CONNECTION=sync` : les deux Listeners s'exécutent immédiatement,
dans le même processus, comme du code PHP normal — pratique pour le
développement/tests car aucun worker n'est nécessaire et le comportement
est immédiatement observable.

Avec `QUEUE_CONNECTION=database` : `JournaliserCreationAnnonce` s'exécute
immédiatement, mais `NotifierBienvenueVendeur` est placé en file d'attente
et n'est traité que lorsqu'un `queue:work` actif le récupère — si aucun
worker ne tourne, ce Listener ne s'exécute JAMAIS, restant indéfiniment
en attente dans la table `jobs`.

`sync` est réservé au développement/tests car il masque justement le
comportement réel de production : une vraie tâche lente exécutée en
`sync` bloquerait la réponse HTTP exactement comme sans queue du tout,
ce qui va à l'encontre de l'intérêt même du mécanisme.
