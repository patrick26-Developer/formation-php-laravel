<?php

declare(strict_types=1);

namespace App;

class InscriptionService {
    public function __construct(private ServiceEmail $serviceEmail) {}

    public function inscrire(string $email): void {
        // ... logique d'inscription (création en base, etc.) omise ici ...

        $this->serviceEmail->envoyer($email, "Bienvenue sur notre plateforme !");
    }
}
