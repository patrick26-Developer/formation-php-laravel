<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";
require_once __DIR__ . "/LivreRepository.en.php";

$repository = new LivreRepository(obtenirConnexion());

// Insert 15 test books if needed
for ($i = 1; $i <= 15; $i++) {
    $repository->creer("Test book $i", "Author $i", 2000 + $i);
}

$parPage = 5;
$page = 2;

$resultats = $repository->lister(tri: 'annee', ordre: 'ASC', page: $page, parPage: $parPage);
$total = $repository->compter();
$totalPages = (int) ceil($total / $parPage);

echo "Page $page / $totalPages (total: $total books)\n";
foreach ($resultats as $livre) {
    echo "{$livre['titre']} ({$livre['annee']})\n";
}
