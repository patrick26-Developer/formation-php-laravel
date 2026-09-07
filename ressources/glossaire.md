# Glossaire

> Termes techniques rencontrés dans la formation, définis simplement, avec un pointeur vers le module où ils sont introduits en détail.

**API (Application Programming Interface)** — Une interface permettant à deux programmes de communiquer, généralement via HTTP et JSON dans le contexte web. [Module 03.4](../03-php-avance/04-construction-api-rest-php-natif/README.md)

**Autoloading** — Mécanisme chargeant automatiquement une classe PHP dès qu'elle est utilisée, sans `require` manuel. [Module 02.7](../02-php-intermediaire/07-composer-autoload-psr/README.md)

**Autorisation** — Déterminer ce qu'un utilisateur authentifié a le droit de faire (à distinguer de l'authentification). [Module 07.5](../07-laravel-intermediaire/05-autorisations-policies-gates/README.md)

**Cache** — Stockage temporaire d'un résultat coûteux à recalculer, pour le réutiliser rapidement. [Module 08.2](../08-laravel-avance/02-cache-optimisation-performance/README.md)

**CI/CD (Intégration/Déploiement Continus)** — Automatisation des tests et du déploiement à chaque modification du code. [Module 05.4](../05-outils-professionnels/04-github-actions-ci-cd-fondamentaux/README.md), [Module 11.3](../11-devops-docker-cicd-avance/03-pipeline-cicd-github-actions-laravel/README.md)

**Composer** — Le gestionnaire de dépendances de PHP, équivalent de npm pour Node.js. [Module 02.7](../02-php-intermediaire/07-composer-autoload-psr/README.md)

**CORS (Cross-Origin Resource Sharing)** — Mécanisme du navigateur autorisant (ou non) des requêtes JavaScript vers un autre domaine. [Module 09.6](../09-api-rest-laravel/06-rate-limiting-securite-api/README.md)

**CRUD** — Create, Read, Update, Delete : les quatre opérations de base sur une donnée persistée. [Module 02.9](../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md)

**CSRF (Cross-Site Request Forgery)** — Attaque forçant un utilisateur authentifié à exécuter une action involontaire ; contrée par un jeton unique par session. [Module 02.6](../02-php-intermediaire/06-securite-web-fondamentaux/README.md)

**Dependency Injection (Injection de dépendances)** — Fournir à une classe ses dépendances de l'extérieur plutôt qu'elle ne les crée elle-même. [Module 08.4](../08-laravel-avance/04-packages-service-providers-personnalises/README.md)

**Docker** — Outil de conteneurisation, isolant une application et ses dépendances dans un environnement reproductible. [Module 05.2](../05-outils-professionnels/02-docker-fondamentaux/README.md)

**Eager loading** — Charger une relation Eloquent en amont d'une boucle, pour éviter le problème N+1. [Module 07.1](../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md)

**Eloquent** — L'ORM (Object-Relational Mapping) intégré à Laravel. [Module 06.4](../06-laravel-fondamentaux/04-eloquent-orm-bases/README.md)

**Framework** — Un cadre de travail structurant une application (Laravel est un framework PHP). [Niveau 06](../06-laravel-fondamentaux/README.md)

**Injection SQL** — Faille permettant d'exécuter du SQL arbitraire via une entrée utilisateur mal filtrée ; contrée par les requêtes préparées. [Module 02.6](../02-php-intermediaire/06-securite-web-fondamentaux/README.md)

**Livewire** — Framework permettant de construire des interfaces réactives en PHP, sans écrire de JavaScript. [Module 10.1](../10-fullstack-laravel-livewire/01-livewire-fondamentaux/README.md)

**Middleware** — Code interceptant une requête HTTP avant (et parfois après) qu'elle n'atteigne le contrôleur. [Module 03.2](../03-php-avance/02-architecture-mvc-from-scratch/README.md), [Module 07.3](../07-laravel-intermediaire/03-middlewares-form-requests/README.md)

**Migration** — Fichier décrivant une modification du schéma de base de données, versionné avec le code. [Module 06.5](../06-laravel-fondamentaux/05-migrations-seeders-factories/README.md)

**Multi-tenancy** — Architecture permettant à une seule application de servir plusieurs clients (tenants) isolés les uns des autres. [Module 08.5](../08-laravel-avance/05-architecture-modulaire/README.md)

**MVC (Modèle-Vue-Contrôleur)** — Pattern d'architecture séparant données (Modèle), présentation (Vue) et logique de traitement (Contrôleur). [Module 03.2](../03-php-avance/02-architecture-mvc-from-scratch/README.md)

**N+1 (Problème)** — Exécuter une requête supplémentaire par élément d'une collection au lieu d'une seule requête groupée. [Module 03.6](../03-php-avance/06-performance-et-optimisation/README.md)

**ORM (Object-Relational Mapping)** — Couche traduisant des objets PHP en lignes de base de données et inversement (Eloquent en est un). [Module 06.4](../06-laravel-fondamentaux/04-eloquent-orm-bases/README.md)

**PDO (PHP Data Objects)** — Interface PHP standard d'accès aux bases de données, indépendante du moteur SQL. [Module 02.8](../02-php-intermediaire/08-pdo-bases-de-donnees-mysql/README.md)

**Policy** — Classe Laravel centralisant les règles d'autorisation pour un modèle donné. [Module 07.5](../07-laravel-intermediaire/05-autorisations-policies-gates/README.md)

**PSR (PHP Standards Recommendations)** — Standards communautaires du langage PHP (autoloading, style de code...). [Module 02.7](../02-php-intermediaire/07-composer-autoload-psr/README.md)

**Rate limiting** — Limitation du nombre de requêtes autorisées par client sur une période donnée. [Module 09.6](../09-api-rest-laravel/06-rate-limiting-securite-api/README.md)

**Repository** — Pattern encapsulant l'accès aux données derrière une interface, indépendante du mécanisme de stockage. [Module 03.1](../03-php-avance/01-design-patterns-php/README.md)

**REST (Representational State Transfer)** — Style d'architecture pour des API HTTP, basé sur les ressources et les verbes HTTP standards. [Module 03.4](../03-php-avance/04-construction-api-rest-php-natif/README.md)

**Sanctum** — Package Laravel d'authentification par jetons pour API/SPA. [Module 09.3](../09-api-rest-laravel/03-authentification-api-sanctum/README.md)

**Scope (Eloquent)** — Méthode encapsulant une clause de requête réutilisable, appelable directement sur le modèle. [Module 07.2](../07-laravel-intermediaire/02-eloquent-scopes-accessors-mutators/README.md)

**Seeder** — Classe peuplant la base de données avec des données de test ou initiales. [Module 06.5](../06-laravel-fondamentaux/05-migrations-seeders-factories/README.md)

**Service Container** — Mécanisme Laravel résolvant automatiquement les dépendances déclarées en paramètre de constructeur. [Module 08.4](../08-laravel-avance/04-packages-service-providers-personnalises/README.md)

**Transaction** — Groupe d'opérations SQL exécutées comme un tout indivisible : soit toutes réussissent, soit aucune n'est appliquée. [Module 04.2](../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.md)

**XSS (Cross-Site Scripting)** — Faille permettant d'injecter du JavaScript malveillant via une entrée non échappée. [Module 02.6](../02-php-intermediaire/06-securite-web-fondamentaux/README.md)
