<?php

declare(strict_types=1);

/**
 * @param array<int, array{produit_id: int, quantite: int}> $lignes
 */
function passerCommande(PDO $pdo, int $clientId, array $lignes): int {
    $pdo->beginTransaction();

    try {
        $stmtCommande = $pdo->prepare("INSERT INTO commandes (client_id) VALUES (:client_id)");
        $stmtCommande->execute(['client_id' => $clientId]);
        $commandeId = (int) $pdo->lastInsertId();

        $stmtProduit = $pdo->prepare("SELECT prix, stock FROM produits WHERE id = :id FOR UPDATE");
        $stmtLigne = $pdo->prepare(
            "INSERT INTO lignes_commande (commande_id, produit_id, quantite, prix_unitaire)
             VALUES (:commande_id, :produit_id, :quantite, :prix_unitaire)"
        );
        $stmtStock = $pdo->prepare("UPDATE produits SET stock = stock - :quantite WHERE id = :id");

        foreach ($lignes as $ligne) {
            $stmtProduit->execute(['id' => $ligne['produit_id']]);
            $produit = $stmtProduit->fetch();

            if ($produit === false) {
                throw new RuntimeException("Product {$ligne['produit_id']} not found.");
            }

            if ($produit['stock'] < $ligne['quantite']) {
                throw new RuntimeException("Insufficient stock for product {$ligne['produit_id']}.");
            }

            $stmtLigne->execute([
                'commande_id' => $commandeId,
                'produit_id' => $ligne['produit_id'],
                'quantite' => $ligne['quantite'],
                'prix_unitaire' => $produit['prix'], // price locked in at the time of purchase
            ]);

            $stmtStock->execute(['quantite' => $ligne['quantite'], 'id' => $ligne['produit_id']]);
        }

        $pdo->commit();

        return $commandeId;
    } catch (Throwable $e) {
        $pdo->rollBack(); // cancels the order AND every line already inserted
        throw $e;
    }
}

/*
 * FOR UPDATE (in the product selection) locks the row for the duration
 * of the transaction: this prevents another concurrent order from
 * reading the same "not yet decremented" stock and selling the last
 * available unit twice (an advanced topic, worth noting for real
 * production use).
 */
