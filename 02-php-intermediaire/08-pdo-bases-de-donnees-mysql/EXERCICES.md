# Exercices — 02.8 PDO et bases de données MySQL

> Créez d'abord une base `formation_php_exercices` et une table `livres` :
> ```sql
> CREATE TABLE livres (
>     id INT AUTO_INCREMENT PRIMARY KEY,
>     titre VARCHAR(150) NOT NULL,
>     auteur VARCHAR(100) NOT NULL,
>     annee INT NOT NULL,
>     disponible BOOLEAN DEFAULT TRUE
> );
> ```

## Exercice 1 — Se connecter et vérifier (facile)

Écrivez un script qui se connecte à `formation_php_exercices` avec PDO (mode exception activé) et affiche "Connexion réussie" si tout fonctionne, ou le message d'erreur sinon.

## Exercice 2 — Insertions (facile)

Insérez 4 livres différents dans la table `livres` via des requêtes préparées, en affichant l'ID généré pour chacun.

## Exercice 3 — Lister et filtrer (moyen)

Écrivez un script qui affiche tous les livres disponibles (`disponible = 1`), triés par année décroissante. Ajoutez ensuite une recherche par auteur (paramètre `?auteur=...` en GET) utilisant `LIKE`.

## Exercice 4 — Mettre à jour et supprimer (moyen)

Écrivez une fonction `marquerIndisponible(PDO $pdo, int $id): int` qui passe un livre à `disponible = 0` et retourne le nombre de lignes affectées. Écrivez une fonction `supprimerLivre(PDO $pdo, int $id): int` similaire pour la suppression. Testez les deux.

## Exercice 5 — Classe `ConnexionBaseDeDonnees` (difficile)

Créez une classe `ConnexionBaseDeDonnees` (Singleton, comme dans le cours) qui centralise la connexion PDO. Réécrivez les exercices 2 et 3 en utilisant `ConnexionBaseDeDonnees::obtenir()` au lieu de recréer une connexion à chaque script.

---

Comparez avec [solutions/](solutions/) une fois terminé.
