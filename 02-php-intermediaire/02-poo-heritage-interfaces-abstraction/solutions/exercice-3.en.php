<?php

declare(strict_types=1);

interface Notifiable {
    public function envoyerNotification(string $message): string;
}

class Email implements Notifiable {
    public function envoyerNotification(string $message): string {
        return "Email sent: $message";
    }
}

class SMS implements Notifiable {
    public function envoyerNotification(string $message): string {
        return "SMS sent: $message";
    }
}

/**
 * @param Notifiable[] $canaux
 */
function notifierTous(array $canaux, string $message): void {
    foreach ($canaux as $canal) {
        echo $canal->envoyerNotification($message) . "\n";
    }
}

notifierTous([new Email(), new SMS()], "Your order has shipped.");
