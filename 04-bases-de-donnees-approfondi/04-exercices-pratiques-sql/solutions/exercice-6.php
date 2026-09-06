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
                throw new RuntimeException("Produit {$ligne['produit_id']} introuvable.");
            }

            if ($produit['stock'] < $ligne['quantite']) {
                throw new RuntimeException("Stock insuffisant pour le produit {$ligne['produit_id']}.");
            }

            $stmtLigne->execute([
                'commande_id' => $commandeId,
                'produit_id' => $ligne['produit_id'],
                'quantite' => $ligne['quantite'],
                'prix_unitaire' => $produit['prix'], // prix figé au moment de l'achat
            ]);

            $stmtStock->execute(['quantite' => $ligne['quantite'], 'id' => $ligne['produit_id']]);
        }

        $pdo->commit();

        return $commandeId;
    } catch (Throwable $e) {
        $pdo->rollBack(); // annule la commande ET toutes les lignes déjà insérées
        throw $e;
    }
}

/*
 * FOR UPDATE (dans la sélection du produit) verrouille la ligne le temps de
 * la transaction : évite qu'une autre commande concurrente lise le même
 * stock "pas encore décrémenté" et vende deux fois la dernière unité
 * disponible (sujet avancé, à noter pour une utilisation en production réelle).
 */
