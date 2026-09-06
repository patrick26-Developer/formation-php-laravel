<?php

declare(strict_types=1);

interface StrategieNotification {
    public function envoyer(string $message): string;
}

class NotificationEmail implements StrategieNotification {
    public function envoyer(string $message): string {
        return "Email envoyé : $message";
    }
}

class NotificationSms implements StrategieNotification {
    public function envoyer(string $message): string {
        return "SMS envoyé : $message";
    }
}

class NotificationFactory {
    public static function creer(string $canal): StrategieNotification {
        return match ($canal) {
            'email' => new NotificationEmail(),
            'sms' => new NotificationSms(),
            default => throw new InvalidArgumentException("Canal inconnu : $canal"),
        };
    }
}

$canal = 'sms'; // pourrait venir d'une préférence utilisateur en base de données
$notification = NotificationFactory::creer($canal);

echo $notification->envoyer("Votre commande est en cours de préparation.");
