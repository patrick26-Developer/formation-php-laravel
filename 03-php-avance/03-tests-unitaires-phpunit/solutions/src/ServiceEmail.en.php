<?php

declare(strict_types=1);

namespace App;

class ServiceEmail {
    public function envoyer(string $destinataire, string $message): bool {
        // In a real project: call an email-sending API (Mailgun, SendGrid...)
        mail($destinataire, "Notification", $message);

        return true;
    }
}
