<?php

$ressourceOuverte = true;
echo "Ressource ouverte : " . var_export($ressourceOuverte, true) . "\n";

try {
    echo "Traitement en cours...\n";
    throw new Exception("Une erreur survient pendant le traitement.");
} catch (Exception $e) {
    echo "Erreur attrapée : " . $e->getMessage() . "\n";
} finally {
    // Ce bloc s'exécute que l'exception ait été levée ou non : c'est l'endroit
    // idéal pour libérer des ressources (fichiers, connexions...) de façon fiable.
    $ressourceOuverte = false;
    echo "Ressource fermée.\n";
}

echo "Ressource ouverte : " . var_export($ressourceOuverte, true) . "\n";
