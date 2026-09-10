<?php

declare(strict_types=1);

namespace App\Tests;

use App\Calculatrice;
use PHPUnit\Framework\TestCase;

class CalculatriceTest extends TestCase {
    // --- Exercise 1 ---

    public function testAdditionnerDeuxNombresPositifs(): void {
        $calculatrice = new Calculatrice();

        $this->assertSame(5, $calculatrice->additionner(2, 3));
    }

    public function testAdditionnerNegatifEtPositif(): void {
        $calculatrice = new Calculatrice();

        $this->assertSame(1, $calculatrice->additionner(-4, 5));
    }

    public function testAdditionnerDeuxNegatifs(): void {
        $calculatrice = new Calculatrice();

        $this->assertSame(-7, $calculatrice->additionner(-3, -4));
    }

    // --- Exercise 2 ---

    public function testDiviserParZeroLeveUneException(): void {
        $calculatrice = new Calculatrice();

        $this->expectException(\InvalidArgumentException::class);

        $calculatrice->diviser(10, 0);
    }

    public function testDiviserRetourneLeBonResultat(): void {
        $calculatrice = new Calculatrice();

        $this->assertSame(5.0, $calculatrice->diviser(10, 2));
    }
}
