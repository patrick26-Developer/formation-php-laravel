<?php

declare(strict_types=1);

namespace App\Tests;

use App\CompteBancaire;
use PHPUnit\Framework\TestCase;

class CompteBancaireAvecSetUpTest extends TestCase {
    private CompteBancaire $compte;

    // setUp() est appelée AUTOMATIQUEMENT par PHPUnit avant CHAQUE méthode
    // de test : chaque test démarre donc avec une instance fraîche à 100€,
    // sans risque qu'un test précédent ait modifié un état partagé.
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
