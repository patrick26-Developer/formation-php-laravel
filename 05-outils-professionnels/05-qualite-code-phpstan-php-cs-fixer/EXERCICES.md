# Exercices — 05.5 Qualité de code

## Exercice 1 — Configurer PHP-CS-Fixer (facile)

Dans un petit projet Composer, installez PHP-CS-Fixer, créez un `.php-cs-fixer.php` avec les règles du cours, volontairement mal formatez un fichier PHP (mauvaise indentation, `array()` au lieu de `[]`), puis lancez `fix` et observez les corrections.

## Exercice 2 — Configurer PHPStan à un niveau bas (facile)

Installez PHPStan, créez `phpstan.neon` avec `level: 0`, analysez un fichier contenant une évidente erreur de type, et observez le message.

## Exercice 3 — Détecter un appel de méthode inexistante (moyen)

Créez une classe avec une méthode `calculerTotal(): float`. Dans un autre fichier, appelez-la avec une faute de frappe (`calculerTtal()`). Lancez PHPStan et vérifiez qu'il détecte l'erreur sans exécuter le code.

## Exercice 4 — Augmenter progressivement le niveau (moyen)

Sur le [grand projet du niveau 03](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.md), lancez PHPStan aux niveaux 0, 3, 6 et 8 successivement sur le dossier `src/`. Notez combien d'erreurs apparaissent à chaque niveau, et corrigez au moins une erreur détectée à un niveau intermédiaire.

## Exercice 5 — Intégrer les deux outils en CI (difficile)

Ajoutez au workflow GitHub Actions du [module 05.4, exercice 2](../04-github-actions-ci-cd-fondamentaux/EXERCICES.md) deux étapes supplémentaires : vérification PHP-CS-Fixer (`--dry-run`) et analyse PHPStan. Poussez un commit avec un style non conforme et vérifiez que la CI échoue bien à cette étape précise (pas seulement sur les tests).

---

Comparez avec [solutions/](solutions/) une fois terminé.
