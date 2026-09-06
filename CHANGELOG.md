# Journal de bord de la formation

> Ce journal trace, session par session, la construction de la formation elle-même : ce qui a été ajouté, quand, et pourquoi. C'est un historique **append-only** (on n'efface jamais une entrée passée) — pour l'état actuel d'avancement, voir [ROADMAP.md](ROADMAP.md).

## 2026-09-06 — Fondation de la formation

- Création de l'architecture complète : 15 niveaux (`00-introduction` à `14-preparation-professionnelle`), 91 modules et projets identifiés et structurés.
- Rédaction des documents maîtres : [README.md](README.md), [SOMMAIRE.md](SOMMAIRE.md), [CONTRIBUTING.md](CONTRIBUTING.md), [ROADMAP.md](ROADMAP.md).
- Définition du gabarit d'un module de cours (objectifs, prérequis, théorie, exemples, points clés).
- Définition du **kit documentaire standard** d'un projet (`README.md`, `INSTALLATION.md`, `EXECUTION.md`, `JOURNAL.md`, `RESSOURCES.md`) — chaque fichier a un rôle distinct et non redondant.
- Décisions structurantes validées avec l'auteur : contenu bilingue FR (source) / EN (traduction différée), stack fullstack Blade + Livewire, MySQL/MariaDB comme SGBD de référence, PHPUnit puis Pest pour les tests.
- Rédaction complète du **Niveau 00 — Introduction** (4 modules) : présentation du parcours, installation de l'environnement, Git/GitHub essentiels, méthodologie d'apprentissage.
- Rédaction complète du module **01.1 — Syntaxe, variables et types** (premier module du Niveau 01), servant de gabarit de qualité pour la suite de la rédaction.
- Génération des stubs (`README.md` planifiés) pour les 84 modules et projets restants, chacun avec son titre, son objectif et son statut.

## 2026-09-06 — Niveau 01 complet (PHP Fondamentaux)

- Rédaction complète des modules 01.2 à 01.9 (opérateurs, boucles, fonctions, tableaux, chaînes/regex, formulaires HTML, fichiers/includes, gestion d'erreurs), chacun avec cours, `EXERCICES.md` et corrigés commentés dans `solutions/`.
- Construction complète du **mini-projet Calculatrice CLI et Web** : logique métier partagée (`src/Calculatrice.php`) entre une interface ligne de commande (`src/cli.php`) et une interface web (`src/web/index.php`), avec le kit documentaire complet (`README.md`, `INSTALLATION.md`, `EXECUTION.md`, `JOURNAL.md`, `RESSOURCES.md`) appliqué pour la première fois en conditions réelles.
- Mise à jour de [SOMMAIRE.md](SOMMAIRE.md) et [ROADMAP.md](ROADMAP.md) : Niveau 01 marqué disponible, passage au Niveau 02.

## 2026-09-06 — Niveau 02 complet (PHP Intermédiaire)

- Rédaction complète des 9 modules du Niveau 02 : POO (bases, héritage/interfaces/abstraction, traits/static/méthodes magiques), gestion des exceptions personnalisées, sessions/cookies/authentification maison, sécurité web (injection SQL, XSS, CSRF), Composer/autoload/PSR-4, PDO, et CRUD complet avec tri/filtre/recherche/pagination — chacun avec cours, `EXERCICES.md` et corrigés commentés.
- Construction complète du **mini-projet Gestionnaire de tâches** : application multi-utilisateurs avec authentification par session (`Auth.php`), protection CSRF réutilisable (`CsrfHelper.php`), Repository CRUD isolant les données par utilisateur (`TacheRepository.php`), et interface web complète (liste avec tri/filtre/recherche/pagination, création, modification, suppression) — avec le kit documentaire complet (`README.md`, `INSTALLATION.md`, `EXECUTION.md`, `JOURNAL.md`, `RESSOURCES.md`).
- Mise à jour de [SOMMAIRE.md](SOMMAIRE.md) et [ROADMAP.md](ROADMAP.md) : Niveau 02 marqué disponible, passage au Niveau 03.

## 2026-09-06 — Niveau 03 complet (PHP Avancé)

- Rédaction complète des 6 modules du Niveau 03 : design patterns (Factory, Strategy, Observer), architecture MVC from scratch (routeur, contrôleurs, vues, middlewares), tests unitaires PHPUnit (assertions, mocks, structure AAA), construction d'API REST en PHP natif (codes de statut, JSON, gestion d'erreurs), bonnes pratiques PSR-12/SOLID/Clean Code, et performance (mesure, OPcache, problème N+1, mémoïsation) — chacun avec cours, `EXERCICES.md` et corrigés commentés.
- Construction complète du **grand projet Mini-framework MVC avec API** : premier projet de la formation utilisant Composer/autoload PSR-4 en conditions réelles, avec un routeur maison, deux contrôleurs (web et API) partageant un même `TacheRepository`, une suite de tests PHPUnit utilisant SQLite en mémoire (sans dépendance à un serveur MySQL), et le kit documentaire complet.
- Ce grand projet clôt la partie "PHP sans framework" de la formation — chaque brique construite (routeur, contrôleur, vue, repository) est désormais reconnaissable comme préparation directe à l'architecture de Laravel (Niveau 06 et suivants).
- Mise à jour de [SOMMAIRE.md](SOMMAIRE.md) et [ROADMAP.md](ROADMAP.md) : Niveau 03 marqué disponible, passage au Niveau 04.

## 2026-09-06 — Niveau 04 complet (Bases de données approfondies)

- Rédaction complète des 4 modules du Niveau 04 : modélisation relationnelle (MCD/MLD, cardinalités, tables pivot), SQL avancé (jointures INNER/LEFT, GROUP BY/HAVING, index, transactions PDO, contraintes d'intégrité référentielle ON DELETE), optimisation des requêtes (EXPLAIN, pièges empêchant l'utilisation d'un index, choix des types de colonnes), et un module de consolidation avec 8 exercices pratiques sur un schéma e-commerce complet (chiffre d'affaires, top clients, transaction de passage de commande avec verrouillage FOR UPDATE, intégrité référentielle, index FULLTEXT).
- Ce niveau n'a pas de mini-projet dédié (transversal par nature) — la consolidation se fait via le module 04.4.
- Mise à jour de [SOMMAIRE.md](SOMMAIRE.md) et [ROADMAP.md](ROADMAP.md) : Niveau 04 marqué disponible, passage au Niveau 05.

## 2026-09-06 — Niveau 05 complet (Outils professionnels)

- Rédaction complète des 5 modules du Niveau 05 : Git avancé (branches, merge vs rebase, résolution de conflits, Pull Requests), Docker (conteneurs vs VM, Dockerfile, commandes essentielles), Docker Compose (stack PHP-FPM + Nginx + MySQL complète, volumes persistants, variables d'environnement, healthchecks), GitHub Actions (workflows CI, services MySQL en pipeline, matrices de versions PHP), et qualité de code (PHP-CS-Fixer, PHPStan par niveaux, intégration CI complète) — chacun avec cours, `EXERCICES.md` et corrigés commentés (commandes, fichiers de configuration YAML/Dockerfile/docker-compose selon le module).
- Ce niveau clôt l'ensemble de la partie **transversale et PHP pur** de la formation (Niveaux 00 à 05, 40/91 modules). La formation bascule maintenant entièrement sur Laravel à partir du Niveau 06.
- Mise à jour de [SOMMAIRE.md](SOMMAIRE.md) et [ROADMAP.md](ROADMAP.md) : Niveau 05 marqué disponible, passage au Niveau 06 (Laravel Fondamentaux).

## 2026-09-06 — Niveau 06 complet (Laravel Fondamentaux)

- Rédaction complète des 7 modules du Niveau 06 : installation Laravel et Artisan (structure moderne Laravel 11+, `bootstrap/app.php`), routing et contrôleurs (Resource Controllers, Model Binding), Blade (héritage de layouts, composants, échappement automatique), Eloquent ORM (CRUD, Query Builder, `$fillable`, `$casts`), migrations/seeders/factories, validation (règles, Form Requests), et CRUD complet avec tri/filtre/recherche/pagination — chaque module reliant explicitement le concept Laravel à son équivalent construit à la main aux niveaux 01-03.
- Construction complète du **mini-projet Blog avec CRUD Laravel** : deux relations Eloquent imbriquées (Category → Article → Comment), eager loading pour éviter le problème N+1, Form Requests séparés création/modification avec règle `unique` conditionnelle, formulaire Blade factorisé en partiel partagé, factories/seeder générant un jeu de données réaliste — avec kit documentaire complet.
- Décision d'architecture notée : ce mini-projet n'inclut volontairement aucune authentification, réservée au mini-projet du Niveau 07 qui réutilisera cette même base.
- Mise à jour de [SOMMAIRE.md](SOMMAIRE.md) et [ROADMAP.md](ROADMAP.md) : Niveau 06 marqué disponible, passage au Niveau 07 (Laravel Intermédiaire).

## 2026-09-06 — Publication sur GitHub

- Ajout de la licence MIT ([LICENSE](LICENSE)).
- Initialisation du dépôt Git local, premier commit regroupant l'intégralité de la formation (Niveaux 00 à 07).
- Création et publication du dépôt public [patrick26-Developer/formation-php-laravel](https://github.com/patrick26-Developer/formation-php-laravel), fusion propre avec le commit initial généré par GitHub (licence), premier push effectué.
