<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Post;
use App\Models\User;
use Illuminate\Notifications\Notification;

class PostAimeNotification extends Notification
{
    public function __construct(public Post $post, public User $utilisateurQuiAime)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'post_id' => $this->post->id,
            'utilisateur_nom' => $this->utilisateurQuiAime->name,
            'message' => "{$this->utilisateurQuiAime->name} a aimé votre publication.",
        ];
    }
}
