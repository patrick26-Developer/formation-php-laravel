<?php

declare(strict_types=1);

namespace App\Tests;

use App\InscriptionService;
use App\ServiceEmail;
use PHPUnit\Framework\TestCase;

class InscriptionServiceTest extends TestCase {
    public function testInscrireEnvoieUnEmailDeBienvenue(): void {
        // Un "faux" ServiceEmail : n'envoie JAMAIS de vrai email pendant les tests.
        $serviceEmailSimule = $this->createMock(ServiceEmail::class);

        $serviceEmailSimule->expects($this->once())
            ->method('envoyer')
            ->with('alice@example.com', 'Bienvenue sur notre plateforme !');

        $inscriptionService = new InscriptionService($serviceEmailSimule);
        $inscriptionService->inscrire('alice@example.com');

        // Aucun assertSame() explicite ici : c'est expects($this->once())->with(...)
        // qui EST l'assertion — le test échoue automatiquement si envoyer() n'est
        // pas appelée exactement une fois avec ces arguments précis.
    }
}
