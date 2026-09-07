# 07.7 — Notifications and Sending Emails

> **Status:** ✅ Available

## 🎯 Objectives

- Send an email with a Mailable.
- Create and send a Notification.
- Understand multiple notification channels (email, database).
- Test email sending in development without actually sending any.

## 📋 Prerequisites

[07.6 — File Uploads and Storage](../06-upload-fichiers-storage/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### Configuring email sending in development

```
# .env
MAIL_MAILER=log    # writes emails to storage/logs/laravel.log instead of actually sending them
```

> 📌 In development, `MAIL_MAILER=log` (or a service like **Mailtrap**, which captures emails in a test inbox) avoids accidentally sending real emails to real addresses while you develop.

### A Mailable: representing an email as a class

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
        return new Envelope(subject: 'Welcome to our platform!');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.bienvenue');
    }
}
```

```blade
{{-- resources/views/emails/bienvenue.blade.php --}}
<h1>Welcome, {{ $user->name }}!</h1>
<p>Thank you for signing up.</p>
```

```php
use Illuminate\Support\Facades\Mail;

Mail::to($user->email)->send(new BienvenueMail($user));
```

> 💡 Recognize `mail()` from [module 02.5](../../02-php-intermediaire/05-sessions-cookies-authentification-maison/README.en.md) and exercise 5 of [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.en.md) (`ServiceEmail`): a Mailable structures this same need (representing a sent email) as a testable class, with its own Blade view for the HTML content.

### Notifications: more flexible than Mailables

A **Notification** can be sent over **several channels** (email, database, SMS...) from a single class.

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
        return ['mail', 'database']; // sent by email AND stored in the database
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New comment on your article')
            ->line("{$this->comment->nom_auteur} commented on your article.")
            ->action('View the comment', route('articles.show', $this->comment->article_id));
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
// Sending
$article->user->notify(new NouveauCommentaireNotification($comment));
```

### Database notifications: a notification center

```bash
php artisan notifications:table
php artisan migrate
```

```php
// app/Models/User.php
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable; // adds ->notify() and ->notifications
}
```

```blade
@foreach (auth()->user()->unreadNotifications as $notification)
    <p>{{ $notification->data['auteur'] }} commented on your article.</p>
@endforeach
```

> 📌 This is exactly the `Notifiable` trait mentioned as an example trait usage in [module 02.3](../../02-php-intermediaire/03-poo-avancee-traits-static-magic-methods/README.en.md) — you now understand both its underlying mechanism (`use TraitName;` injects methods) **and** its concrete usage in Laravel.

## ✅ Key takeaways

- `MAIL_MAILER=log` in development avoids accidentally sending real emails.
- A Mailable structures an email as a testable class, with its own view.
- A Notification can target several channels (email, database) from a single class.
- The `Notifiable` trait on `User` adds `notify()` and access to stored notifications.

## ➡️ Going further

- [laravel.com/docs — Mail](https://laravel.com/docs/mail)
- [laravel.com/docs — Notifications](https://laravel.com/docs/notifications)
- [Module 08.1 — Jobs, Queues, Events, Listeners](../../08-laravel-avance/01-jobs-queues-events-listeners/README.md) *(French only)* (sending these emails in the background, without slowing down the HTTP response)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [07.6 — File Uploads and Storage](../06-upload-fichiers-storage/README.en.md) · **Next:** [Mini-project: Classifieds Platform](../projet-mini-04-plateforme-annonces/README.en.md)
