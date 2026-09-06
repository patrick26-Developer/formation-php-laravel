<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.php";
require_once __DIR__ . "/LivreRepository.php";

$repository = new LivreRepository(obtenirConnexion());

// Insère 15 livres de test si besoin
for ($i = 1; $i <= 15; $i++) {
    $repository->creer("Livre de test $i", "Auteur $i", 2000 + $i);
}

$parPage = 5;
$page = 2;

$resultats = $repository->lister(tri: 'annee', ordre: 'ASC', page: $page, parPage: $parPage);
$total = $repository->compter();
$totalPages = (int) ceil($total / $parPage);

echo "Page $page / $totalPages (total : $total livres)\n";
foreach ($resultats as $livre) {
    echo "{$livre['titre']} ({$livre['annee']})\n";
}
