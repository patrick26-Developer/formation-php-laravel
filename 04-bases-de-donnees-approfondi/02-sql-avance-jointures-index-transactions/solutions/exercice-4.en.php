<?php

declare(strict_types=1);

function effectuerVirement(PDO $pdo, int $compteSource, int $compteDestination, float $montant, bool $simulerErreur = false): void {
    try {
        $pdo->beginTransaction();

        $pdo->prepare("UPDATE comptes SET solde = solde - :montant WHERE id = :id")
            ->execute(['montant' => $montant, 'id' => $compteSource]);

        if ($simulerErreur) {
            throw new RuntimeException("Simulated error after the first UPDATE.");
        }

        $pdo->prepare("UPDATE comptes SET solde = solde + :montant WHERE id = :id")
            ->execute(['montant' => $montant, 'id' => $compteDestination]);

        $pdo->commit();
        echo "Transfer completed successfully.\n";
    } catch (Throwable $e) {
        $pdo->rollBack(); // undoes the debit already applied: the database stays consistent
        echo "Transfer cancelled: " . $e->getMessage() . "\n";
    }
}

// --- Test with a real PDO (adapt the connection to your environment) ---
// $pdo = new PDO("mysql:host=127.0.0.1;dbname=test_transactions", "root", "");
// effectuerVirement($pdo, 1, 2, 100, simulerErreur: false); // success
// effectuerVirement($pdo, 1, 2, 100, simulerErreur: true);  // cancelled, account 1's balance unchanged
