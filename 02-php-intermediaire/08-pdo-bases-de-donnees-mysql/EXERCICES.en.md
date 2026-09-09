# Exercises — 02.8 PDO and MySQL Databases

> First create a `formation_php_exercices` database and a `livres` table:
> ```sql
> CREATE TABLE livres (
>     id INT AUTO_INCREMENT PRIMARY KEY,
>     titre VARCHAR(150) NOT NULL,
>     auteur VARCHAR(100) NOT NULL,
>     annee INT NOT NULL,
>     disponible BOOLEAN DEFAULT TRUE
> );
> ```

## Exercise 1 — Connect and verify (easy)

Write a script that connects to `formation_php_exercices` with PDO (exception mode enabled) and prints "Connection successful" if everything works, or the error message otherwise.

## Exercise 2 — Insertions (easy)

Insert 4 different books into the `livres` table via prepared statements, printing the generated ID for each.

## Exercise 3 — List and filter (medium)

Write a script that displays all available books (`disponible = 1`), sorted by descending year. Then add a search by author (a `?auteur=...` GET parameter) using `LIKE`.

## Exercise 4 — Update and delete (medium)

Write a function `marquerIndisponible(PDO $pdo, int $id): int` that sets a book to `disponible = 0` and returns the number of affected rows. Write a similar function `supprimerLivre(PDO $pdo, int $id): int` for deletion. Test both.

## Exercise 5 — `ConnexionBaseDeDonnees` class (hard)

Create a `ConnexionBaseDeDonnees` class (Singleton, as in the lesson) that centralizes the PDO connection. Rewrite exercises 2 and 3 using `ConnexionBaseDeDonnees::obtenir()` instead of recreating a connection in every script.

---

Compare with [solutions/](solutions/README.en.md) once done.
