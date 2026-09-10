<?php

declare(strict_types=1);

const SEUIL_REMISE = 100;
const TAUX_REMISE = 0.9;
const TAUX_TVA = 0.2;

function calculerTotalHT(array $articles): float
{
    $total = 0;
    foreach ($articles as $article) {
        $total += $article['prix'] * $article['quantite'];
    }

    return $total;
}

function appliquerRemiseEventuelle(float $totalHT): float
{
    return $totalHT > SEUIL_REMISE ? $totalHT * TAUX_REMISE : $totalHT;
}

function calculerTVA(float $totalHT): float
{
    return $totalHT * TAUX_TVA;
}

function formaterFacture(float $totalHT, float $tva, float $totalTTC): string
{
    return "Total excl. VAT: $totalHT, VAT: $tva, Total incl. VAT: $totalTTC";
}

function traiterCommande(array $commande): string
{
    $totalHT = calculerTotalHT($commande['articles']);
    $totalHT = appliquerRemiseEventuelle($totalHT);
    $tva = calculerTVA($totalHT);
    $totalTTC = $totalHT + $tva;

    return formaterFacture($totalHT, $tva, $totalTTC);
}

// Each function can now be read and tested independently of the others.
