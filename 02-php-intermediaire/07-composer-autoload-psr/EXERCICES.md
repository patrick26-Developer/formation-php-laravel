# Exercices — 02.7 Composer, autoload, PSR

> Ces exercices nécessitent Composer installé (voir [00.2](../../00-introduction/02-installation-environnement/README.md)). Contrairement aux modules précédents, les solutions sont fournies comme une **structure de projet complète** dans `solutions/`, pas un seul fichier.

## Exercice 1 — Initialiser un projet Composer (facile)

Créez un nouveau dossier, lancez `composer init` (répondez aux questions, ou créez le `composer.json` à la main), puis ajoutez une configuration `autoload` PSR-4 faisant correspondre `App\` au dossier `src/`. Lancez `composer dump-autoload`.

## Exercice 2 — Première classe autoloadée (facile)

Dans le projet de l'exercice 1, créez `src/Saluer.php` avec une classe `Saluer` dans le namespace `App`, ayant une méthode `bonjour(string $prenom): string`. Depuis un `index.php` à la racine, incluez uniquement `vendor/autoload.php`, importez la classe avec `use App\Saluer;`, instanciez-la et appelez la méthode.

## Exercice 3 — Sous-namespace (moyen)

Ajoutez `src/Services/Calculatrice.php` avec `namespace App\Services;`. Vérifiez que PSR-4 la charge automatiquement sans modification de `composer.json` (le sous-dossier correspond au sous-namespace). Utilisez-la depuis `index.php` avec `use App\Services\Calculatrice;`.

## Exercice 4 — Installer une vraie dépendance (moyen)

Installez la librairie `nesbot/carbon` (`composer require nesbot/carbon`, une librairie de manipulation de dates très utilisée avec Laravel). Utilisez-la dans `index.php` pour afficher la date du jour formatée en français.

## Exercice 5 — `composer.lock` en pratique (difficile)

Supprimez votre dossier `vendor/` (simulez un "nouveau développeur qui clone le projet"). Relancez uniquement `composer install` (pas `composer update`). Vérifiez dans `composer.lock` que les versions installées correspondent exactement à celles d'avant suppression. Expliquez en commentaire pourquoi cette garantie est importante pour une équipe.

---

Comparez avec [solutions/](solutions/) une fois terminé — la solution y est fournie comme un projet Composer minimal complet, prêt à inspecter.
