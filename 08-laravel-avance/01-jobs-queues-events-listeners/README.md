# 08.1 — Jobs, Queues, Events, Listeners

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre l'intérêt du traitement asynchrone.
- Créer et distribuer un Job vers une file d'attente.
- Configurer un driver de queue et lancer un worker.
- Découpler du code avec des Events et Listeners.

## 📋 Prérequis

[Niveau 07 — Laravel Intermédiaire](../../07-laravel-intermediaire/README.md), notamment [07.7 — Notifications](../../07-laravel-intermediaire/07-notifications-mail/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Le problème : les tâches lentes bloquent la réponse HTTP

Au [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md), l'envoi d'un email (`$annonce->user->notify(...)`) se produit **pendant** le traitement de la requête HTTP : l'utilisateur qui envoie un message attend que l'email parte réellement (connexion au serveur SMTP, potentiellement 1 à 3 secondes) avant de recevoir sa page de confirmation. Pour des opérations lentes (email, génération de PDF, appel à une API externe, traitement d'image), on **reporte** ce travail à **après** la réponse, via une file d'attente.

### Créer et distribuer un Job

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
// Dans le contrôleur, au lieu d'exécuter directement :
EnvoyerNotificationMessage::dispatch($message);
```

> 💡 `dispatch()` place le Job dans une file d'attente **immédiatement** (quelques millisecondes) et la réponse HTTP part sans attendre l'envoi réel de l'email — traité **séparément**, par un processus dédié (le "worker").

### Configurer et lancer un worker

```
# .env
QUEUE_CONNECTION=database   # ou "redis" en production pour de meilleures performances
```

```bash
php artisan queue:table   # génère la migration de la table "jobs" (driver database)
php artisan migrate

php artisan queue:work     # démarre un worker : traite les jobs en continu
```

> ⚠️ **En production, `queue:work` doit tourner en permanence** (via un superviseur de processus comme Supervisor, approfondi au [module 11.4](../../11-devops-docker-cicd-avance/04-deploiement-production/README.md)) — si le worker s'arrête, les jobs s'accumulent dans la file sans être traités.

### Gérer les échecs

```php
class EnvoyerNotificationMessage implements ShouldQueue
{
    public int $tries = 3;           // nombre de tentatives avant d'abandonner
    public int $backoff = 30;          // secondes d'attente entre chaque tentative

    public function failed(\Throwable $exception): void
    {
        logger()->error('Échec définitif de l\'envoi de notification', ['erreur' => $exception->getMessage()]);
    }
}
```

### Events et Listeners : découpler des actions liées à un même déclencheur

Un **Event** représente "quelque chose qui s'est produit" ; un ou plusieurs **Listeners** réagissent, sans que le code qui déclenche l'événement ait besoin de les connaître.

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
class EnvoyerNotificationVendeur implements ShouldQueue // un Listener peut lui-même être mis en file d'attente
{
    public function handle(MessageEnvoye $event): void
    {
        $event->message->annonce->user->notify(new NouveauMessageNotification($event->message));
    }
}
```

```php
// Dans le contrôleur : un seul déclenchement, potentiellement plusieurs réactions
MessageEnvoye::dispatch($message);
```

> 📌 C'est le pattern **Observer** du [module 03.1](../../03-php-avance/01-design-patterns-php/README.md), automatisé par Laravel : `GestionnaireCommande` et ses `Observateur` deviennent ici `MessageEnvoye` et ses `Listener`s. L'avantage par rapport à tout écrire dans le contrôleur : ajouter une nouvelle réaction (par exemple, journaliser aussi le message) ne nécessite **aucune modification** du contrôleur, seulement un nouveau Listener enregistré.

## ✅ Points clés à retenir

- `ShouldQueue` + `dispatch()` reporte une tâche lente à un traitement asynchrone, sans bloquer la réponse HTTP.
- Un worker (`queue:work`) doit tourner en continu pour traiter la file ; à superviser en production.
- Events et Listeners automatisent le pattern Observer (module 03.1) : un déclencheur, plusieurs réactions découplées.
- Un Listener peut lui-même implémenter `ShouldQueue` pour être traité de façon asynchrone.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Queues](https://laravel.com/docs/queues)
- [laravel.com/docs — Events](https://laravel.com/docs/events)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 07 — Laravel Intermédiaire](../../07-laravel-intermediaire/README.md) · **Suite :** [08.2 — Cache et optimisation de performance](../02-cache-optimisation-performance/README.md)
