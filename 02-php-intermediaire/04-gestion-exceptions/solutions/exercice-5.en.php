<?php

declare(strict_types=1);

class ValidationException extends Exception {
    public function __construct(private array $erreurs) {
        parent::__construct("Validation failed with " . count($erreurs) . " error(s).");
    }

    public function getErreurs(): array {
        return $this->erreurs;
    }
}

function validerFormulaire(array $donnees): void {
    $erreurs = [];

    if (trim($donnees['nom'] ?? '') === '') {
        $erreurs[] = "Name is required.";
    }

    if (!filter_var($donnees['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Email is not valid.";
    }

    $age = $donnees['age'] ?? '';
    if (!is_numeric($age) || (int) $age < 18 || (int) $age > 120) {
        $erreurs[] = "Age must be a number between 18 and 120.";
    }

    // We accumulate ALL the errors before throwing the exception once,
    // rather than stopping at the first one found: the user sees
    // everything they need to fix in one go.
    if (!empty($erreurs)) {
        throw new ValidationException($erreurs);
    }
}

try {
    validerFormulaire(['nom' => '', 'email' => 'not-an-email', 'age' => '15']);
} catch (ValidationException $e) {
    echo $e->getMessage() . "\n";
    foreach ($e->getErreurs() as $erreur) {
        echo "- $erreur\n";
    }
}
