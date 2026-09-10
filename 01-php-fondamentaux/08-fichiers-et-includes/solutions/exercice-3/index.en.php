<?php

require_once __DIR__ . "/config.en.php";
require_once __DIR__ . "/fonctions.en.php";

echo "VAT applied: " . (TVA_TAUX * 100) . "%\n";
echo "Price incl. VAT for €50 excl. VAT: " . calculerTTC(50) . " €\n";
