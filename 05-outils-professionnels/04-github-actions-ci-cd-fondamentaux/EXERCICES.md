# Exercices — 05.4 GitHub Actions : fondamentaux CI/CD

> Nécessite un dépôt GitHub réel (public ou privé) pour observer l'exécution des workflows dans l'onglet "Actions".

## Exercice 1 — Premier workflow (facile)

Créez `.github/workflows/hello.yml` qui se déclenche sur chaque `push` et exécute simplement `echo "Bonjour depuis GitHub Actions"`. Poussez et vérifiez son exécution dans l'onglet Actions.

## Exercice 2 — Lancer PHPUnit en CI (facile)

Reprenez le [grand projet du niveau 03](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.md) (ses tests utilisent SQLite, aucun service supplémentaire nécessaire). Créez un workflow qui installe PHP 8.3, exécute `composer install`, puis `./vendor/bin/phpunit`.

## Exercice 3 — Matrice de versions PHP (moyen)

Modifiez le workflow de l'exercice 2 pour utiliser une `strategy.matrix` testant le code sur PHP 8.2 **et** 8.3, afin de vérifier la compatibilité avec plusieurs versions.

## Exercice 4 — Ajouter un service MySQL (moyen)

Créez un second workflow avec un service `mysql` (comme dans le cours), qui exécute une simple requête de vérification (`mysql -h 127.0.0.1 -uroot -psecret -e "SELECT 1"`) pour confirmer que le service est bien accessible depuis le job.

## Exercice 5 — Pipeline complet avec plusieurs jobs (difficile)

Créez un workflow avec deux jobs séparés : `tests` (PHPUnit) et `qualite` (une commande simulant PHP-CS-Fixer en `--dry-run`, même sans l'installer réellement — un simple `echo` suffit pour l'exercice). Faites en sorte que `qualite` ne s'exécute **qu'après** le succès de `tests`, en utilisant `needs:`.

---

Comparez avec [solutions/](solutions/) une fois terminé.
