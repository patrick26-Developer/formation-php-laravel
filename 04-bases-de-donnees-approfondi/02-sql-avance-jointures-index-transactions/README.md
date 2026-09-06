# 04.2 — SQL avancé : jointures, index, transactions

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Maîtriser les différents types de jointures SQL.
- Comprendre le rôle des index et quand les utiliser.
- Utiliser les transactions pour garantir la cohérence des données.
- Comprendre les contraintes d'intégrité référentielle.

## 📋 Prérequis

[04.1 — Modélisation relationnelle](../01-modelisation-relationnelle-mcd-mld/README.md)

## ⏱️ Durée estimée

2h30.

## 📖 Théorie

### Les jointures : combiner des données de plusieurs tables

En reprenant le schéma `utilisateurs`/`commandes` du module précédent :

```sql
-- INNER JOIN : uniquement les lignes qui ont une correspondance dans les DEUX tables
SELECT utilisateurs.nom, commandes.montant
FROM commandes
INNER JOIN utilisateurs ON utilisateurs.id = commandes.utilisateur_id;
-- Un utilisateur SANS commande n'apparaît PAS dans le résultat.

-- LEFT JOIN : TOUTES les lignes de la table de gauche, avec NULL si pas de correspondance
SELECT utilisateurs.nom, commandes.montant
FROM utilisateurs
LEFT JOIN commandes ON commandes.utilisateur_id = utilisateurs.id;
-- Un utilisateur SANS commande apparaît quand même, avec commandes.montant à NULL.
```

> 📌 Règle pratique : utilisez `LEFT JOIN` dès que vous voulez "tous les X, avec leurs Y s'ils existent" (ex : tous les utilisateurs, avec le nombre de commandes, y compris 0). Utilisez `INNER JOIN` quand seule l'intersection vous intéresse.

### Jointures multiples

```sql
SELECT emprunts.date_emprunt, livres.titre, membres.nom
FROM emprunts
INNER JOIN livres ON livres.id = emprunts.livre_id
INNER JOIN membres ON membres.id = emprunts.membre_id
WHERE emprunts.date_retour_effective IS NULL; -- emprunts en cours
```

### `GROUP BY` et agrégations

```sql
-- Nombre de commandes par utilisateur
SELECT utilisateurs.nom, COUNT(commandes.id) AS nombre_commandes
FROM utilisateurs
LEFT JOIN commandes ON commandes.utilisateur_id = utilisateurs.id
GROUP BY utilisateurs.id, utilisateurs.nom;

-- Montant total dépensé par utilisateur, seulement ceux qui ont dépensé plus de 100€
SELECT utilisateurs.nom, SUM(commandes.montant) AS total_depense
FROM utilisateurs
INNER JOIN commandes ON commandes.utilisateur_id = utilisateurs.id
GROUP BY utilisateurs.id, utilisateurs.nom
HAVING SUM(commandes.montant) > 100;
```

> 📌 `WHERE` filtre les lignes **avant** regroupement, `HAVING` filtre les groupes **après** agrégation (`SUM`, `COUNT`...). C'est pourquoi `HAVING` est nécessaire ici : on ne peut pas écrire `WHERE SUM(...)`.

### Les index : accélérer les recherches

Un **index** est une structure de données qui permet à MySQL de retrouver des lignes sans parcourir toute la table (comme l'index d'un livre). Une clé primaire est automatiquement indexée ; les autres colonnes fréquemment filtrées ou jointes doivent l'être manuellement.

```sql
-- Accélère les requêtes qui filtrent/joignent sur commandes.utilisateur_id
CREATE INDEX idx_commandes_utilisateur ON commandes(utilisateur_id);

-- Index composite : utile si vous filtrez SOUVENT sur ces deux colonnes ensemble
CREATE INDEX idx_taches_utilisateur_statut ON taches(utilisateur_id, terminee);
```

> ⚠️ Les index accélèrent les lectures (`SELECT`) mais **ralentissent légèrement les écritures** (`INSERT`/`UPDATE`/`DELETE`, car l'index doit aussi être mis à jour) et consomment de l'espace disque. Ne pas indexer "au cas où" toutes les colonnes — indexez celles réellement utilisées dans des `WHERE`, `JOIN` ou `ORDER BY` fréquents. Approfondi avec `EXPLAIN` au [module 04.3](../03-optimisation-requetes/README.md).

### Les transactions : garantir la cohérence

Une **transaction** regroupe plusieurs opérations SQL en un tout **atomique** : soit toutes réussissent, soit aucune n'est appliquée. Indispensable dès que plusieurs écritures doivent rester cohérentes entre elles.

```sql
START TRANSACTION;

UPDATE comptes SET solde = solde - 100 WHERE id = 1; -- débit
UPDATE comptes SET solde = solde + 100 WHERE id = 2; -- crédit

COMMIT; -- valide définitivement les deux modifications
-- ou : ROLLBACK; -- annule tout si une erreur est détectée entre-temps
```

En PHP avec PDO :

```php
<?php
try {
    $pdo->beginTransaction();

    $pdo->prepare("UPDATE comptes SET solde = solde - :montant WHERE id = :id")
        ->execute(['montant' => 100, 'id' => 1]);

    $pdo->prepare("UPDATE comptes SET solde = solde + :montant WHERE id = :id")
        ->execute(['montant' => 100, 'id' => 2]);

    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack(); // annule TOUT si une des deux requêtes a échoué
    throw $e;
}
```

> ⚠️ Sans transaction, un crash serveur ou une exception **entre** les deux `UPDATE` laisserait la base dans un état incohérent (l'argent débité mais jamais crédité). C'est précisément le genre de bug que les transactions préviennent.

### Contraintes d'intégrité référentielle

```sql
CREATE TABLE commandes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
        ON DELETE CASCADE   -- supprime les commandes si l'utilisateur est supprimé
        ON UPDATE CASCADE    -- répercute un changement d'ID (rare en pratique)
);
```

| Option `ON DELETE` | Comportement |
|---|---|
| `CASCADE` | Supprime aussi les lignes liées (déjà utilisé au [mini-projet 02](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md)) |
| `SET NULL` | Met la clé étrangère à `NULL` (nécessite que la colonne accepte `NULL`) |
| `RESTRICT` (par défaut) | Empêche la suppression tant que des lignes liées existent |

## ✅ Points clés à retenir

- `INNER JOIN` = intersection, `LEFT JOIN` = tout de la table de gauche + correspondances éventuelles.
- `WHERE` filtre avant regroupement, `HAVING` filtre après agrégation.
- Un index accélère les lectures mais ralentit les écritures : à utiliser sur les colonnes réellement filtrées/jointes.
- Une transaction garantit qu'un groupe d'opérations réussit ou échoue **entièrement**, jamais partiellement.
- `ON DELETE CASCADE`/`SET NULL`/`RESTRICT` définissent le comportement lors de la suppression d'une ligne référencée.

## ➡️ Pour aller plus loin

- [dev.mysql.com — JOIN](https://dev.mysql.com/doc/refman/8.0/en/join.html)
- [Module 04.3 — Optimisation des requêtes SQL](../03-optimisation-requetes/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [04.1 — Modélisation relationnelle](../01-modelisation-relationnelle-mcd-mld/README.md) · **Suite :** [04.3 — Optimisation des requêtes SQL](../03-optimisation-requetes/README.md)
