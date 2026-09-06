<?php

declare(strict_types=1);

interface StrategieTri {
    public function trier(array $donnees): array;
}

class TriAlphabetique implements StrategieTri {
    public function trier(array $donnees): array {
        sort($donnees);
        return $donnees;
    }
}

class TriParLongueur implements StrategieTri {
    public function trier(array $donnees): array {
        usort($donnees, fn(string $a, string $b): int => strlen($a) <=> strlen($b));
        return $donnees;
    }
}

class ListeMots {
    public function __construct(private StrategieTri $strategie) {}

    public function obtenirTriee(array $mots): array {
        return $this->strategie->trier($mots);
    }
}

$mots = ["banane", "kiwi", "pomme", "abricot"];

$liste1 = new ListeMots(new TriAlphabetique());
print_r($liste1->obtenirTriee($mots));

$liste2 = new ListeMots(new TriParLongueur());
print_r($liste2->obtenirTriee($mots));
