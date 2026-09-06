# 07.7 — Notifications et envoi d'emails

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Envoyer un email avec un Mailable.
- Créer et envoyer une Notification.
- Comprendre les canaux de notification multiples (email, base de données).
- Tester l'envoi d'emails en développement sans en envoyer réellement.

## 📋 Prérequis

[07.6 — Upload de fichiers et Storage](../06-upload-fichiers-storage/README.md)

## ⏱️ Durée estimée

1h30.

## 📖 Théorie

### Configurer l'envoi d'emails en développement

```
# .env
MAIL_MAILER=log    # écrit les emails dans storage/logs/laravel.log au lieu de les envoyer réellement
```

> 📌 En développement, `MAIL_MAILER=log` (ou un service comme **Mailtrap**, qui capture les emails dans une boîte de réception de test) évite d'envoyer accidentellement de vrais emails à de vraies adresses pendant que vous développez.

### Un Mailable : représenter un email comme une classe

```bash
php artisan make:mail BienvenueMail
```

```php
// app/Mail/BienvenueMail.php
class BienvenueMail extends Mailable
{
    public function __construct(public User $user) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Bienvenue sur notre plateforme !');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.bienvenue');
    }
}
```

```blade
{{-- resources/views/emails/bienvenue.blade.php --}}
<h1>Bienvenue, {{ $user->name }} !</h1>
<p>Merci de vous être inscrit.</p>
```

```php
use Illuminate\Support\Facades\Mail;

Mail::to($user->email)->send(new BienvenueMail($user));
```

> 💡 Reconnaissez `mail()` du [module 02.5](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.md) et de l'exercice 5 du [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md) (`ServiceEmail`) : un Mailable structure ce même besoin (représenter un email envoyé) en une classe testable, avec sa propre vue Blade pour le contenu HTML.

### Les Notifications : plus flexibles que les Mailables

Une **Notification** peut être envoyée sur **plusieurs canaux** (email, base de données, SMS...) depuis une seule classe.

```bash
php artisan make:notification NouveauCommentaireNotification
```

```php
// app/Notifications/NouveauCommentaireNotification.php
class NouveauCommentaireNotification extends Notification
{
    public function __construct(public Comment $comment) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // envoyée par email ET stockée en base
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau commentaire sur votre article')
            ->line("{$this->comment->nom_auteur} a commenté votre article.")
            ->action('Voir le commentaire', route('articles.show', $this->comment->article_id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'article_id' => $this->comment->article_id,
            'auteur' => $this->comment->nom_auteur,
        ];
    }
}
```

```php
// Envoi
$article->user->notify(new NouveauCommentaireNotification($comment));
```

### Notifications en base de données : un centre de notifications

```bash
php artisan notifications:table
php artisan migrate
```

```php
// app/Models/User.php
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable; // ajoute ->notify() et ->notifications
}
```

```blade
@foreach (auth()->user()->unreadNotifications as $notification)
    <p>{{ $notification->data['auteur'] }} a commenté votre article.</p>
@endforeach
```

> 📌 C'est exactement le trait `Notifiable` mentionné en exemple d'usage des traits au [module 02.3](../../02-php-intermediaire/03-poo-avancee-traits-static-magic-methods/README.md) — vous en comprenez maintenant le mécanisme sous-jacent (`use NomDuTrait;` injecte des méthodes) **et** l'usage concret dans Laravel.

## ✅ Points clés à retenir

- `MAIL_MAILER=log` en développement évite l'envoi accidentel de vrais emails.
- Un Mailable structure un email comme une classe testable, avec sa propre vue.
- Une Notification peut cibler plusieurs canaux (email, base de données) depuis une seule classe.
- Le trait `Notifiable` sur `User` ajoute `notify()` et l'accès aux notifications stockées.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Mail](https://laravel.com/docs/mail)
- [laravel.com/docs — Notifications](https://laravel.com/docs/notifications)
- [Module 08.1 — Jobs, Queues, Events, Listeners](../../08-laravel-avance/01-jobs-queues-events-listeners/README.md) (envoyer ces emails en arrière-plan, sans ralentir la réponse HTTP)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [07.6 — Upload de fichiers et Storage](../06-upload-fichiers-storage/README.md) · **Suite :** [Mini-projet : Plateforme d'annonces](../projet-mini-04-plateforme-annonces/README.md)
