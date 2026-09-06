# Exercices — 01.8 Fichiers, includes et organisation

## Exercice 1 — Journal simple (facile)

Écrivez un script qui ajoute une ligne horodatée (`date('Y-m-d H:i:s')`) à un fichier `journal.txt` à chaque exécution, sans écraser les lignes précédentes. Exécutez-le 3 fois et vérifiez le contenu du fichier.

## Exercice 2 — Lecture et comptage (facile)

Créez un fichier `mots.txt` contenant plusieurs mots (un par ligne). Écrivez un script qui lit le fichier et affiche le nombre total de lignes et le nombre total de caractères.

## Exercice 3 — Séparer configuration et fonctions (moyen)

Créez trois fichiers : `config.php` (une constante `TVA_TAUX`), `fonctions.php` (une fonction `calculerTTC`), et `index.php` qui les inclut tous les deux avec `require_once` et les utilise. Utilisez `__DIR__` pour tous les chemins.

## Exercice 4 — Le piège de l'inclusion multiple (moyen)

Créez un fichier `outils.php` avec une fonction. Dans `index.php`, incluez-le deux fois avec `require` (pas `require_once`). Observez l'erreur obtenue, puis corrigez avec `require_once`.

## Exercice 5 — Mini-système de templates (difficile)

Créez `partials/header.php` et `partials/footer.php` (du HTML simple), et un `index.php` qui les inclut autour d'un contenu dynamique (une variable `$titre` affichée dans le `<title>` du header). Utilisez des chemins basés sur `__DIR__`.

---

Comparez avec [solutions/](solutions/) une fois terminé.
