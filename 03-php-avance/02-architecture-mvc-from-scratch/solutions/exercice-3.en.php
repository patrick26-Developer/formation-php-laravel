<?php

declare(strict_types=1);

require_once __DIR__ . "/ProduitController.en.php";

$controller = new ProduitController();
$controller->liste(); // renders the produits/liste.php view with the prepared data
