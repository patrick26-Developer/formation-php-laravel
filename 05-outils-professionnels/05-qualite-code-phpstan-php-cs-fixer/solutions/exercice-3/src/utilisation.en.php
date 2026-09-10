<?php

declare(strict_types=1);

require_once __DIR__ . '/Facture.en.php';

$facture = new Facture(100);

echo $facture->calculerTtal(); // deliberate typo: "Ttal" instead of "Total"

// PHPStan reports:
// "Call to an undefined method Facture::calculerTtal()."
// Detected simply by READING the code, without ever running it — a bug
// that, without PHPStan, would only surface by running this exact code path.
