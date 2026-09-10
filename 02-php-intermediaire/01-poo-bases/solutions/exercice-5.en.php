<?php

declare(strict_types=1);

class Panier {
    /** @var array<int, array{nom: string, prix: float}> */
    private array $articles = [];

    public function ajouterArticle(string $nom, float $prix): void {
        $this->articles[] = ['nom' => $nom, 'prix' => $prix];
    }

    public function calculerTotal(): float {
        return array_reduce(
            $this->articles,
            fn(float $total, array $article): float => $total + $article['prix'],
            0.0
        );
    }

    public function nombreArticles(): int {
        return count($this->articles);
    }
}

$panier = new Panier();
$panier->ajouterArticle("Clavier", 49.99);
$panier->ajouterArticle("Souris", 19.99);
$panier->ajouterArticle("Tapis de souris", 9.99);

echo "Number of items: " . $panier->nombreArticles() . "\n";
echo "Total: " . round($panier->calculerTotal(), 2) . " €\n";
