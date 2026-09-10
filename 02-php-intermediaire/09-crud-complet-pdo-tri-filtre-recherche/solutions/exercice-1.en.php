<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.en.php";
require_once __DIR__ . "/LivreRepository.en.php";

$repository = new LivreRepository(obtenirConnexion());

$id = $repository->creer("Le Meilleur des mondes", "Aldous Huxley", 1932);
echo "Created with ID $id\n";

$livre = $repository->trouver($id);
print_r($livre);

$repository->modifier($id, "Le Meilleur des mondes", "Aldous Huxley", 1932);
echo "Updated.\n";

$repository->supprimer($id);
echo "Deleted.\n";

var_dump($repository->trouver($id)); // null: the book no longer exists
