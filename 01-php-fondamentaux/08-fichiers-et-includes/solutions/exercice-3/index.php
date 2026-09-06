<?php

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/fonctions.php";

echo "TVA appliquée : " . (TVA_TAUX * 100) . "%\n";
echo "Prix TTC de 50€ HT : " . calculerTTC(50) . " €\n";
