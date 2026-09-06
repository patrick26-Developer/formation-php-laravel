<?php

declare(strict_types=1);

require_once __DIR__ . '/Facture.php';

$facture = new Facture(100);

echo $facture->calculerTtal(); // faute de frappe volontaire : "Ttal" au lieu de "Total"

// PHPStan signale :
// "Call to an undefined method Facture::calculerTtal()."
// Détecté par simple LECTURE du code, sans jamais l'exécuter — un bug qui,
// sans PHPStan, ne se révélerait qu'en exécutant ce chemin de code précis.
