<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class NouvelAbonneNotification extends Notification
{
    public function __construct(public User $abonne)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database']; // pas d'email pour un événement aussi fréquent — juste le centre de notifications
    }

    public function toArray(object $notifiable): array
    {
        return [
            'abonne_id' => $this->abonne->id,
            'abonne_nom' => $this->abonne->name,
            'message' => "{$this->abonne->name} a commencé à vous suivre.",
        ];
    }
}
