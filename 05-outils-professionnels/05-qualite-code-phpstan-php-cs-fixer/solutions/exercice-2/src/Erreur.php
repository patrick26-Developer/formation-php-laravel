<?php

declare(strict_types=1);

class Erreur
{
    public function additionner(int $a, int $b): int
    {
        return $a + $b;
    }
}

$erreur = new Erreur();
$erreur->additionner("dix", 5);
// PHPStan (même au niveau 0) signale :
// "Parameter #1 $a of method Erreur::additionner() expects int, string given."
