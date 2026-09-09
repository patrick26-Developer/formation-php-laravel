# Solutions — 07.7 Notifications and Sending Emails

## Exercise 1

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
The email's full HTML content appears in `storage/logs/laravel.log` after sending.

## Exercise 2

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
            ->subject('Your article has been published')
            ->line("The article \"{$this->article->titre}\" is now live.")
            ->action('View the article', route('articles.show', $this->article));
    }
}
```

## Exercise 3

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
$user->notifications; // contains the database record after sending
```

## Exercise 4

```blade
<span>{{ auth()->user()->unreadNotifications->count() }} notification(s)</span>
<ul>
    @foreach (auth()->user()->unreadNotifications as $notification)
        <li>{{ $notification->data['titre'] }}</li>
    @endforeach
</ul>
<form method="POST" action="{{ route('notifications.marquer-lu') }}">
    @csrf
    <button type="submit">Mark all as read</button>
</form>
```
```php
public function marquerLu(Request $request)
{
    $request->user()->unreadNotifications->markAsRead();
    return back();
}
```

## Exercise 5

```php
public function store(Request $request, Article $article): RedirectResponse
{
    $data = $request->validate([
        'nom_auteur' => ['required', 'max:100'],
        'contenu' => ['required', 'max:2000'],
    ]);

    $article->comments()->create($data);

    // We explicitly check that an author exists before notifying:
    // without this guard, ->notify() on null would cause a fatal error.
    if ($article->user !== null) {
        $article->user->notify(new NouveauCommentaireNotification($article->comments()->latest()->first()));
    }

    return redirect()->route('articles.show', $article)->with('succes', 'Comment posted.');
}
```
