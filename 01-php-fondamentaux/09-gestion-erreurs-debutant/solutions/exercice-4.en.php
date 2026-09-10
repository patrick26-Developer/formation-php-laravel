<?php

$ressourceOuverte = true;
echo "Resource open: " . var_export($ressourceOuverte, true) . "\n";

try {
    echo "Processing...\n";
    throw new Exception("An error occurs during processing.");
} catch (Exception $e) {
    echo "Caught error: " . $e->getMessage() . "\n";
} finally {
    // This block runs whether the exception was thrown or not: it's the
    // ideal place to reliably release resources (files, connections...).
    $ressourceOuverte = false;
    echo "Resource closed.\n";
}

echo "Resource open: " . var_export($ressourceOuverte, true) . "\n";
