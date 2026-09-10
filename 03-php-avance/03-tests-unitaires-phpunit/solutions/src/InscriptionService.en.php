<?php

declare(strict_types=1);

namespace App;

class InscriptionService {
    public function __construct(private ServiceEmail $serviceEmail) {}

    public function inscrire(string $email): void {
        // ... registration logic (database creation, etc.) omitted here ...

        $this->serviceEmail->envoyer($email, "Welcome to our platform!");
    }
}
