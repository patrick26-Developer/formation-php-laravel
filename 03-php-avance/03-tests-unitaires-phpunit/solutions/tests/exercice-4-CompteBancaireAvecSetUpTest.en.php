<?php

declare(strict_types=1);

namespace App\Tests;

use App\CompteBancaire;
use PHPUnit\Framework\TestCase;

class CompteBancaireAvecSetUpTest extends TestCase {
    private CompteBancaire $compte;

    // setUp() is called AUTOMATICALLY by PHPUnit before EVERY test
    // method: each test therefore starts with a fresh 100€ instance,
    // with no risk that a previous test modified some shared state.
    protected function setUp(): void {
        $this->compte = new CompteBancaire(100);
    }

    public function testDeposerAugmenteLeSolde(): void {
        $this->compte->deposer(50);

        $this->assertSame(150.0, $this->compte->getSolde());
    }

    public function testRetirerValideDiminueLeSolde(): void {
        $this->compte->retirer(30);

        $this->assertSame(70.0, $this->compte->getSolde());
    }

    public function testRetraitExcessifLeveUneException(): void {
        $this->expectException(\Exception::class);

        $this->compte->retirer(500);
    }
}
