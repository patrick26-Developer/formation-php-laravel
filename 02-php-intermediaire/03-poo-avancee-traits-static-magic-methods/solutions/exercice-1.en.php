<?php

declare(strict_types=1);

trait Loggable {
    public function log(string $message): void {
        // static::class returns the name of the ACTUAL class using the trait
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
$email->log("Email sent successfully.");

$paiement = new ServicePaiement();
$paiement->log("Payment of €49.99 validated.");
