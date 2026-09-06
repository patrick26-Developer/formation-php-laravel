<?php

declare(strict_types=1);

function chargerConfiguration(): array {
    throw new RuntimeException("Fichier de configuration introuvable");
}

function demarrerApplication(): void {
    try {
        chargerConfiguration();
    } catch (RuntimeException $erreurTechnique) {
        // On "traduit" une erreur technique bas niveau en erreur métier plus
        // parlante pour l'appelant, sans PERDRE la cause originale.
        throw new Exception("Impossible de démarrer l'application", 0, $erreurTechnique);
    }
}

try {
    demarrerApplication();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
    echo "Cause originale : " . $e->getPrevious()->getMessage() . "\n";
}
