<?php

declare(strict_types=1);

function chargerConfiguration(): array {
    throw new RuntimeException("Configuration file not found");
}

function demarrerApplication(): void {
    try {
        chargerConfiguration();
    } catch (RuntimeException $erreurTechnique) {
        // We "translate" a low-level technical error into a more meaningful
        // business error for the caller, without LOSING the original cause.
        throw new Exception("Unable to start the application", 0, $erreurTechnique);
    }
}

try {
    demarrerApplication();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Original cause: " . $e->getPrevious()->getMessage() . "\n";
}
