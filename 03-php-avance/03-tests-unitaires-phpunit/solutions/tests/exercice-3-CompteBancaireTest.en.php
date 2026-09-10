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
            $this->fail("An exception should have been thrown.");
        } catch (\Exception $e) {
            // We check HERE, in the catch block, that the balance hasn't
            // moved: this proves the operation failed "atomically"
            // (all or nothing), with no unwanted partial effect.
            $this->assertSame(100.0, $compte->getSolde());
        }
    }
}
