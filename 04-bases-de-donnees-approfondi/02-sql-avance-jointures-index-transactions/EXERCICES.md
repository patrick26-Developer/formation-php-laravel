# Exercices — 04.2 SQL avancé

> Utilisez ce schéma pour tous les exercices :
> ```sql
> CREATE TABLE utilisateurs (id INT AUTO_INCREMENT PRIMARY KEY, nom VARCHAR(100));
> CREATE TABLE commandes (
>     id INT AUTO_INCREMENT PRIMARY KEY,
>     utilisateur_id INT NOT NULL,
>     montant DECIMAL(10,2) NOT NULL,
>     FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs(id)
> );
> ```
> Insérez quelques utilisateurs, dont au moins un sans commande, et plusieurs commandes.

## Exercice 1 — INNER JOIN (facile)

Écrivez une requête listant le nom de l'utilisateur et le montant de chaque commande.

## Exercice 2 — LEFT JOIN (facile)

Écrivez une requête listant TOUS les utilisateurs avec le montant de leurs commandes (ou `NULL` s'ils n'en ont pas). Comparez le nombre de lignes retournées avec l'exercice 1.

## Exercice 3 — GROUP BY et HAVING (moyen)

Écrivez une requête donnant, pour chaque utilisateur, le nombre de commandes et le montant total dépensé, en n'affichant que ceux ayant dépensé plus de 50€ au total.

## Exercice 4 — Transaction PDO (moyen)

Écrivez un script PHP simulant un virement entre deux comptes (table `comptes` avec `id`, `solde`) dans une transaction PDO. Testez le cas où tout se passe bien, puis simulez une erreur (par exemple en forçant une exception après le premier `UPDATE`) et vérifiez que `rollBack()` annule bien le premier `UPDATE`.

## Exercice 5 — Index et EXPLAIN (difficile)

Créez une table `journal_activite` avec au moins 10 000 lignes générées (utilisez une boucle PHP + insertions, ou une procédure SQL), une colonne `utilisateur_id` non indexée. Exécutez `EXPLAIN SELECT * FROM journal_activite WHERE utilisateur_id = 42;` et notez le nombre de lignes examinées. Créez un index sur `utilisateur_id`, relancez le même `EXPLAIN`, et comparez.

---

Comparez avec [solutions/](solutions/) une fois terminé.
