<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NouveauMessageNotification extends Notification
{
    public function __construct(public Message $message)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouveau message concernant votre annonce')
            ->line("{$this->message->expediteur_nom} vous a envoyé un message concernant \"{$this->message->annonce->titre}\".")
            ->line($this->message->contenu)
            ->action('Voir l\'annonce', route('annonces.show', $this->message->annonce_id));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'annonce_id' => $this->message->annonce_id,
            'annonce_titre' => $this->message->annonce->titre,
            'expediteur_nom' => $this->message->expediteur_nom,
        ];
    }
}
