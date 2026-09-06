<?php

declare(strict_types=1);

class ValidationException extends Exception {
    public function __construct(private array $erreurs) {
        parent::__construct("La validation a échoué avec " . count($erreurs) . " erreur(s).");
    }

    public function getErreurs(): array {
        return $this->erreurs;
    }
}

function validerFormulaire(array $donnees): void {
    $erreurs = [];

    if (trim($donnees['nom'] ?? '') === '') {
        $erreurs[] = "Le nom est requis.";
    }

    if (!filter_var($donnees['email'] ?? '', FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide.";
    }

    $age = $donnees['age'] ?? '';
    if (!is_numeric($age) || (int) $age < 18 || (int) $age > 120) {
        $erreurs[] = "L'âge doit être un nombre entre 18 et 120.";
    }

    // On accumule TOUTES les erreurs avant de lever l'exception une seule
    // fois, plutôt que de s'arrêter à la première trouvée : l'utilisateur
    // voit d'un coup tout ce qu'il doit corriger.
    if (!empty($erreurs)) {
        throw new ValidationException($erreurs);
    }
}

try {
    validerFormulaire(['nom' => '', 'email' => 'pas-un-email', 'age' => '15']);
} catch (ValidationException $e) {
    echo $e->getMessage() . "\n";
    foreach ($e->getErreurs() as $erreur) {
        echo "- $erreur\n";
    }
}
