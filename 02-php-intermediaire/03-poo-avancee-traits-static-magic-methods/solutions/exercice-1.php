<?php

declare(strict_types=1);

trait Loggable {
    public function log(string $message): void {
        // static::class retourne le nom de la classe RÉELLE qui utilise le trait
        echo "[" . static::class . "] $message\n";
    }
}

class ServiceEmail {
    use Loggable;
}

class ServicePaiement {
    use Loggable;
}

$email = new ServiceEmail();
$email->log("Email envoyé avec succès.");

$paiement = new ServicePaiement();
$paiement->log("Paiement de 49.99€ validé.");
