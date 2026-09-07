# Exercices — 11.3 Pipeline CI/CD complet pour Laravel

## Exercice 1 — Pipeline CI de base (facile)

Créez `.github/workflows/ci.yml` avec installation PHP, Composer, et exécution des tests Pest (sans base de données pour commencer, sur un projet sans migrations).

## Exercice 2 — Ajouter le service MySQL (facile)

Ajoutez un service `mysql` au workflow. Exécutez `php artisan migrate` puis les tests sur le [mini-projet du niveau 08](../../08-laravel-avance/projet-mini-05-saas-multi-utilisateurs/README.md) (qui a de vraies migrations).

## Exercice 3 — Faire échouer volontairement le pipeline (moyen)

Introduisez un test qui échoue délibérément. Poussez sur une branche et observez GitHub Actions marquer le workflow en échec (croix rouge). Corrigez le test et vérifiez que le pipeline repasse au vert.

## Exercice 4 — Ajouter PHPStan et PHP-CS-Fixer (moyen)

Installez ces deux outils (module 05.5) sur le projet. Ajoutez leurs étapes au pipeline, AVANT les tests. Introduisez une violation de style volontaire et vérifiez qu'elle bloque le pipeline avant même d'exécuter les tests.

## Exercice 5 — Construire et pousser une image (difficile)

Ajoutez un job CD qui construit l'image Docker du [mini-projet du niveau 11.1](../01-dockerisation-application-laravel-complete/EXERCICES.md) et la pousse vers GitHub Container Registry (`ghcr.io`), taguée à la fois `:latest` et par SHA de commit. Vérifiez les deux tags dans l'onglet "Packages" du dépôt GitHub.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
