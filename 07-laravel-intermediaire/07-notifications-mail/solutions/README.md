# Solutions — 07.7 Notifications et envoi d'emails

## Exercice 1

```bash
php artisan make:mail BienvenueMail
```
```php
Mail::to($user->email)->send(new BienvenueMail($user));
```
```
# .env
MAIL_MAILER=log
```
Le contenu HTML complet de l'email apparaît dans `storage/logs/laravel.log` après l'envoi.

## Exercice 2

```bash
php artisan make:notification ArticlePublieNotification
```
```php
class ArticlePublieNotification extends Notification
{
    public function __construct(public Article $article) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Votre article a été publié')
            ->line("L'article \"{$this->article->titre}\" est maintenant en ligne.")
            ->action('Voir l\'article', route('articles.show', $this->article));
    }
}
```

## Exercice 3

```bash
php artisan notifications:table
php artisan migrate
```
```php
public function via(object $notifiable): array { return ['mail', 'database']; }

public function toArray(object $notifiable): array
{
    return ['article_id' => $this->article->id, 'titre' => $this->article->titre];
}
```
```php
$user->notifications; // contient l'enregistrement en base après envoi
```

## Exercice 4

```blade
<span>{{ auth()->user()->unreadNotifications->count() }} notification(s)</span>
<ul>
    @foreach (auth()->user()->unreadNotifications as $notification)
        <li>{{ $notification->data['titre'] }}</li>
    @endforeach
</ul>
<form method="POST" action="{{ route('notifications.marquer-lu') }}">
    @csrf
    <button type="submit">Tout marquer comme lu</button>
</form>
```
```php
public function marquerLu(Request $request)
{
    $request->user()->unreadNotifications->markAsRead();
    return back();
}
```

## Exercice 5

```php
public function store(Request $request, Article $article): RedirectResponse
{
    $data = $request->validate([
        'nom_auteur' => ['required', 'max:100'],
        'contenu' => ['required', 'max:2000'],
    ]);

    $article->comments()->create($data);

    // On vérifie explicitement la présence d'un auteur avant de notifier :
    // sans cette garde, ->notify() sur null provoquerait une erreur fatale.
    if ($article->user !== null) {
        $article->user->notify(new NouveauCommentaireNotification($article->comments()->latest()->first()));
    }

    return redirect()->route('articles.show', $article)->with('succes', 'Commentaire publié.');
}
```
