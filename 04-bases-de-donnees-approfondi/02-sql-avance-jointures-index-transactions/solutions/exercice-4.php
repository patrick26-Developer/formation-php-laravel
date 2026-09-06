<?php

declare(strict_types=1);

function effectuerVirement(PDO $pdo, int $compteSource, int $compteDestination, float $montant, bool $simulerErreur = false): void {
    try {
        $pdo->beginTransaction();

        $pdo->prepare("UPDATE comptes SET solde = solde - :montant WHERE id = :id")
            ->execute(['montant' => $montant, 'id' => $compteSource]);

        if ($simulerErreur) {
            throw new RuntimeException("Erreur simulée après le premier UPDATE.");
        }

        $pdo->prepare("UPDATE comptes SET solde = solde + :montant WHERE id = :id")
            ->execute(['montant' => $montant, 'id' => $compteDestination]);

        $pdo->commit();
        echo "Virement effectué avec succès.\n";
    } catch (Throwable $e) {
        $pdo->rollBack(); // annule le débit déjà effectué : la base reste cohérente
        echo "Virement annulé : " . $e->getMessage() . "\n";
    }
}

// --- Test avec un vrai PDO (adapter la connexion à votre environnement) ---
// $pdo = new PDO("mysql:host=127.0.0.1;dbname=test_transactions", "root", "");
// effectuerVirement($pdo, 1, 2, 100, simulerErreur: false); // succès
// effectuerVirement($pdo, 1, 2, 100, simulerErreur: true);  // annulé, solde du compte 1 inchangé
