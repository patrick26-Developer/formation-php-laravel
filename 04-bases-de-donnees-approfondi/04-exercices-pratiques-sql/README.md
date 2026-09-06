# 04.4 — Exercices pratiques SQL

> **Statut :** ✅ Disponible

## 🎯 Objectifs

Consolider l'ensemble du Niveau 04 (modélisation, jointures, index, transactions, optimisation) à travers une série d'exercices progressifs sur un schéma unique, plus proche d'un cas réel que les exemples isolés des modules précédents.

## 📋 Prérequis

[04.1](../01-modelisation-relationnelle-mcd-mld/README.md), [04.2](../02-sql-avance-jointures-index-transactions/README.md) et [04.3](../03-optimisation-requetes/README.md).

## ⏱️ Durée estimée

2h30.

## 📖 Le schéma de travail

Tous les exercices de ce module utilisent ce schéma d'e-commerce simplifié. Créez-le avant de commencer :

```sql
CREATE DATABASE IF NOT EXISTS exercices_sql_04;
USE exercices_sql_04;

CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    inscrit_le DATE NOT NULL
);

CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    prix DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0
);

CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    passee_le DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id)
);

-- Table pivot : une commande contient plusieurs produits, chacun avec une quantité
CREATE TABLE lignes_commande (
    commande_id INT NOT NULL,
    produit_id INT NOT NULL,
    quantite INT NOT NULL,
    prix_unitaire DECIMAL(10, 2) NOT NULL, -- prix au moment de la commande (peut différer du prix actuel du produit)
    PRIMARY KEY (commande_id, produit_id),
    FOREIGN KEY (commande_id) REFERENCES commandes(id),
    FOREIGN KEY (produit_id) REFERENCES produits(id)
);
```

> 💡 Remarquez `prix_unitaire` dupliqué dans `lignes_commande` plutôt que d'aller chercher `produits.prix` à chaque fois : c'est **volontaire**, pas une violation du principe du module 04.1. Le prix d'un produit peut changer après qu'une commande a été passée — une facture doit toujours refléter le prix payé **au moment de l'achat**, pas le prix actuel.

Insérez quelques données de test (au moins 5 clients, 8 produits, 10 commandes avec plusieurs lignes chacune) avant de continuer.

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md) — une dizaine d'exercices progressifs couvrant modélisation, jointures multiples, agrégations, transactions et optimisation.

---

**Précédent :** [04.3 — Optimisation des requêtes SQL](../03-optimisation-requetes/README.md) · **Suite :** [Niveau 05 — Outils professionnels](../../05-outils-professionnels/README.md)
