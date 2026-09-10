<?php

declare(strict_types=1);

namespace App\Tests;

use App\InscriptionService;
use App\ServiceEmail;
use PHPUnit\Framework\TestCase;

class InscriptionServiceTest extends TestCase {
    public function testInscrireEnvoieUnEmailDeBienvenue(): void {
        // A "fake" ServiceEmail: NEVER sends a real email during tests.
        $serviceEmailSimule = $this->createMock(ServiceEmail::class);

        $serviceEmailSimule->expects($this->once())
            ->method('envoyer')
            ->with('alice@example.com', 'Welcome to our platform!');

        $inscriptionService = new InscriptionService($serviceEmailSimule);
        $inscriptionService->inscrire('alice@example.com');

        // No explicit assertSame() here: expects($this->once())->with(...)
        // IS the assertion — the test automatically fails if envoyer() is
        // not called exactly once with these precise arguments.
    }
}
