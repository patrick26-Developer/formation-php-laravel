<?php

declare(strict_types=1);

interface StrategieNotification {
    public function envoyer(string $message): string;
}

class NotificationEmail implements StrategieNotification {
    public function envoyer(string $message): string {
        return "Email sent: $message";
    }
}

class NotificationSms implements StrategieNotification {
    public function envoyer(string $message): string {
        return "SMS sent: $message";
    }
}

class NotificationFactory {
    public static function creer(string $canal): StrategieNotification {
        return match ($canal) {
            'email' => new NotificationEmail(),
            'sms' => new NotificationSms(),
            default => throw new InvalidArgumentException("Unknown channel: $canal"),
        };
    }
}

$canal = 'sms'; // could come from a user preference stored in the database
$notification = NotificationFactory::creer($canal);

echo $notification->envoyer("Your order is being prepared.");
