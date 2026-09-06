<?php

declare(strict_types=1);

require_once __DIR__ . "/ProduitController.php";

$controller = new ProduitController();
$controller->liste(); // affiche la vue produits/liste.php avec les données préparées
