<?php

require_once __DIR__ . "/config.en.php";

function calculerTTC(float $prixHT): float {
    return round($prixHT * (1 + TVA_TAUX), 2);
}
