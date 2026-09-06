<?php

const TVA_TAUX = 0.20;

$prixArticle1 = 12.50;
$quantiteArticle1 = 2;

$prixArticle2 = 5.90;
$quantiteArticle2 = 1;

$prixArticle3 = 8.00;
$quantiteArticle3 = 3;

$totalHT = ($prixArticle1 * $quantiteArticle1)
    + ($prixArticle2 * $quantiteArticle2)
    + ($prixArticle3 * $quantiteArticle3);

$montantTVA = $totalHT * TVA_TAUX;
$totalTTC = $totalHT + $montantTVA;

echo "Total HT : " . round($totalHT, 2) . " €\n";
echo "Montant TVA : " . round($montantTVA, 2) . " €\n";
echo "Total TTC : " . round($totalTTC, 2) . " €\n";
