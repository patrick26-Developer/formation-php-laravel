# Aide-mémoire SQL (MySQL/MariaDB)

## CRUD de base

```sql
SELECT colonne1, colonne2 FROM table WHERE condition ORDER BY colonne ASC LIMIT 10 OFFSET 20;
INSERT INTO table (col1, col2) VALUES (?, ?);
UPDATE table SET col1 = ? WHERE id = ?;
DELETE FROM table WHERE id = ?;
```

## Jointures

```sql
SELECT c.nom, COUNT(o.id) AS nb_commandes
FROM clients c
INNER JOIN orders o ON o.client_id = c.id      -- seulement les clients AVEC commande
LEFT JOIN orders o ON o.client_id = c.id        -- TOUS les clients, commande ou non
GROUP BY c.id
HAVING COUNT(o.id) > 5;                            -- filtre APRÈS agrégation (WHERE filtre AVANT)
```

## Contraintes et intégrité référentielle

```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    client_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE
    -- ON DELETE : CASCADE (supprime en chaîne) | RESTRICT (empêche) | SET NULL
);
```

## Index

```sql
CREATE INDEX idx_produits_categorie ON produits(categorie_id);
CREATE UNIQUE INDEX idx_users_email ON users(email);
EXPLAIN SELECT ...;    -- vérifie si un index est réellement utilisé (type: ALL = pas d'index = lent)
```

## Transactions

```sql
START TRANSACTION;
UPDATE comptes SET solde = solde - 100 WHERE id = 1;
UPDATE comptes SET solde = solde + 100 WHERE id = 2;
COMMIT;    -- ou ROLLBACK; en cas d'erreur détectée
```

## Fonctions d'agrégation courantes

```sql
COUNT(*), SUM(colonne), AVG(colonne), MIN(colonne), MAX(colonne)
GROUP_CONCAT(colonne SEPARATOR ', ')
```

## Types de colonnes fréquents

| Type | Usage |
|---|---|
| `BIGINT UNSIGNED` | Clés primaires/étrangères |
| `VARCHAR(n)` | Texte court, borné |
| `TEXT` | Texte long |
| `DECIMAL(10,2)` | **Toujours** pour de l'argent — jamais `FLOAT` (imprécisions d'arrondi) |
| `BOOLEAN` | Vrai/faux |
| `DATE` / `DATETIME` / `TIMESTAMP` | Dates, avec ou sans heure |
| `JSON` | Données semi-structurées, à utiliser avec parcimonie |

**Voir aussi :** [Niveau 04 — Bases de données approfondies](../../04-bases-de-donnees-approfondi/README.md)
