<?php

declare(strict_types=1);

require_once __DIR__ . "/connexion.php";
require_once __DIR__ . "/LivreRepository.php";

$repository = new LivreRepository(obtenirConnexion());

$id = $repository->creer("Le Meilleur des mondes", "Aldous Huxley", 1932);
echo "Créé avec l'ID $id\n";

$livre = $repository->trouver($id);
print_r($livre);

$repository->modifier($id, "Le Meilleur des mondes", "Aldous Huxley", 1932);
echo "Modifié.\n";

$repository->supprimer($id);
echo "Supprimé.\n";

var_dump($repository->trouver($id)); // null : le livre n'existe plus
