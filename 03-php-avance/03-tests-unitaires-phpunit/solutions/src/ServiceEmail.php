<?php

declare(strict_types=1);

namespace App;

class ServiceEmail {
    public function envoyer(string $destinataire, string $message): bool {
        // Dans un vrai projet : appel à une API d'envoi d'email (Mailgun, SendGrid...)
        mail($destinataire, "Notification", $message);

        return true;
    }
}
