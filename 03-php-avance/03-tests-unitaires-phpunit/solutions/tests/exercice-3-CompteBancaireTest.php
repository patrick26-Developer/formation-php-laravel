<?php

declare(strict_types=1);

namespace App\Tests;

use App\CompteBancaire;
use PHPUnit\Framework\TestCase;

class CompteBancaireTest extends TestCase {
    public function testDeposerAugmenteLeSolde(): void {
        $compte = new CompteBancaire(100);

        $compte->deposer(50);

        $this->assertSame(150.0, $compte->getSolde());
    }

    public function testRetirerValideDiminueLeSolde(): void {
        $compte = new CompteBancaire(100);

        $compte->retirer(30);

        $this->assertSame(70.0, $compte->getSolde());
    }

    public function testRetraitExcessifLeveUneExceptionEtNeChangeRienAuSolde(): void {
        $compte = new CompteBancaire(100);

        try {
            $compte->retirer(500);
            $this->fail("Une exception aurait dû être levée.");
        } catch (\Exception $e) {
            // On vérifie ICI, dans le catch, que le solde n'a pas bougé :
            // c'est la preuve que l'opération a échoué de façon "atomique"
            // (tout ou rien), sans effet partiel indésirable.
            $this->assertSame(100.0, $compte->getSolde());
        }
    }
}
