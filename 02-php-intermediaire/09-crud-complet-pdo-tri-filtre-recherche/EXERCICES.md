# Exercices — 02.9 CRUD complet avec PDO

> Utilisez la table `livres` créée au module 02.8, ou recréez-la :
> ```sql
> CREATE TABLE livres (
>     id INT AUTO_INCREMENT PRIMARY KEY,
>     titre VARCHAR(150) NOT NULL,
>     auteur VARCHAR(100) NOT NULL,
>     annee INT NOT NULL,
>     disponible BOOLEAN DEFAULT TRUE
> );
> ```

## Exercice 1 — `LivreRepository` : CRUD de base (facile)

Créez une classe `LivreRepository` avec un constructeur prenant un `PDO`, et les méthodes `creer()`, `trouver(int $id)`, `modifier()`, `supprimer()`. Testez chacune.

## Exercice 2 — Lister avec tri (moyen)

Ajoutez une méthode `lister(string $tri = 'annee', string $ordre = 'DESC'): array` qui valide `$tri` contre une liste blanche (`titre`, `auteur`, `annee`) avant de l'utiliser dans la requête. Testez avec plusieurs colonnes de tri.

## Exercice 3 — Recherche et filtre combinés (moyen)

Étendez `lister()` pour accepter un paramètre `?string $recherche` (recherche sur `titre` OU `auteur`) et `?bool $disponible` (filtre exact). Combinez les deux dans une même requête (recherche ET filtre appliqués simultanément si les deux sont fournis).

## Exercice 4 — Pagination (difficile)

Ajoutez `page` et `parPage` à `lister()`, avec `LIMIT`/`OFFSET`, et une méthode `compter(?string $recherche = null, ?bool $disponible = null): int` reflétant les mêmes filtres. Insérez au moins 15 livres de test, puis affichez la page 2 avec 5 résultats par page.

## Exercice 5 — Petit tableau de bord CLI (difficile)

Écrivez un script en ligne de commande qui accepte des arguments (`php script.php --tri=titre --ordre=asc --recherche=Orwell`) via `$argv`, les parse simplement, appelle `lister()` avec ces valeurs, et affiche un tableau texte formaté des résultats dans le terminal.

---

Comparez avec [solutions/](solutions/) une fois terminé.
