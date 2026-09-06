<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.php";
require_once __DIR__ . "/LivreRepository.php";

$repository = new LivreRepository(obtenirConnexion());

echo "--- Triés par titre, croissant ---\n";
foreach ($repository->lister(tri: 'titre', ordre: 'ASC') as $livre) {
    echo "{$livre['titre']} ({$livre['annee']})\n";
}

echo "\n--- Triés par année, décroissant ---\n";
foreach ($repository->lister(tri: 'annee', ordre: 'DESC') as $livre) {
    echo "{$livre['titre']} ({$livre['annee']})\n";
}

echo "\n--- Tentative avec une colonne non autorisée (repli sur 'annee') ---\n";
foreach ($repository->lister(tri: 'mot_de_passe_admin') as $livre) {
    echo "{$livre['titre']}\n";
}
