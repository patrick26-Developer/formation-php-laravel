# 06.1 — Installation de Laravel et Artisan

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Installer un projet Laravel moderne.
- Comprendre la structure de dossiers d'une application Laravel.
- Utiliser les commandes Artisan essentielles.
- Configurer les variables d'environnement.

## 📋 Prérequis

[Niveau 05 — Outils professionnels](../../05-outils-professionnels/README.md) complété.

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Installer Laravel

```bash
composer create-project laravel/laravel mon-projet
cd mon-projet
php artisan serve
```

Ouvrez `http://localhost:8000` : la page de bienvenue Laravel confirme que tout fonctionne.

> 📌 `composer create-project` fait exactement ce que vous avez fait manuellement au [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md) et au [grand projet du niveau 03](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.md) : il télécharge Laravel (une dépendance Composer comme une autre) et son autoloading PSR-4, déjà configuré pour vous.

### La structure d'un projet Laravel moderne

Depuis Laravel 11, la structure a été **allégée** par rapport aux versions précédentes — un point important à connaître si vous consultez d'anciens tutoriels :

```
mon-projet/
├── app/
│   ├── Http/Controllers/    # vos contrôleurs (module 06.2)
│   ├── Models/                # vos modèles Eloquent (module 06.4)
│   └── Providers/               # Service Providers (module 08.4)
├── bootstrap/
│   └── app.php                    # configuration centrale : routes, middlewares, exceptions (nouveau depuis Laravel 11)
├── config/                          # fichiers de configuration (database.php, mail.php...)
├── database/
│   ├── migrations/                     # schéma de base de données versionné (module 06.5)
│   ├── seeders/                          # données de test (module 06.5)
│   └── factories/                          # génération de fausses données (module 06.5)
├── public/
│   └── index.php                             # LE point d'entrée unique (front controller, module 03.2)
├── resources/
│   └── views/                                  # templates Blade (module 06.3)
├── routes/
│   ├── web.php                                   # routes pour navigateur (avec sessions, CSRF)
│   └── api.php                                     # routes pour API (module 09), sans état de session
├── storage/                                          # fichiers générés (logs, cache, uploads)
├── tests/                                              # tests Pest/PHPUnit (module 08.3)
├── .env                                                  # variables d'environnement (JAMAIS versionné)
├── artisan                                                 # l'exécutable de la CLI Artisan
└── composer.json
```

> 📌 **Avant Laravel 11**, la configuration des middlewares et des exceptions se trouvait dans `app/Http/Kernel.php` et `app/Exceptions/Handler.php`. Ces fichiers ont été **retirés du squelette par défaut** : tout se configure maintenant de façon centralisée dans `bootstrap/app.php`. Si vous consultez un tutoriel qui mentionne `Kernel.php`, sachez qu'il documente une version antérieure — le concept reste valide, seul l'emplacement a changé.

### Reconnaître ce que vous savez déjà

| Ce que vous avez construit (Niveau 03) | Son équivalent Laravel |
|---|---|
| `Routeur.php` (module 03.2) | `routes/web.php` + le routeur interne de Laravel |
| `Vue.php` (module 03.2) | Le moteur Blade (module 06.3) |
| `TacheRepository.php` (module 02.9) | Un modèle Eloquent (module 06.4) |
| `Database.php` (Singleton PDO) | La connexion gérée automatiquement via `config/database.php` |
| `public/index.php` (front controller) | `public/index.php` (identique dans le principe) |

### Le fichier `.env`

```
# .env
APP_NAME="Mon Projet"
APP_ENV=local
APP_KEY=base64:...           # généré automatiquement, sert au chiffrement
APP_DEBUG=true                 # affiche les erreurs détaillées en développement (JAMAIS true en production)

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mon_projet
DB_USERNAME=root
DB_PASSWORD=
```

> 📌 Ce fichier remplace directement le `config.php` que vous écriviez à la main au [module 02.9](../../02-php-intermediaire/09-crud-complet-pdo-tri-filtre-recherche/README.md) et au [grand projet du niveau 03](../../03-php-avance/grand-projet-01-mini-framework-mvc-avec-api/README.md). Il n'est **jamais versionné** (`.gitignore` l'exclut par défaut) ; `.env.example` sert de modèle versionné, exactement comme vos `config.example.php` précédents.

### Les commandes Artisan essentielles

```bash
php artisan --version              # version de Laravel installée
php artisan list                     # liste toutes les commandes disponibles
php artisan tinker                     # un REPL PHP avec l'application Laravel chargée (variables, modèles...)

php artisan make:controller TacheController    # génère un contrôleur
php artisan make:model Tache -m                  # génère un modèle + sa migration (-m)
php artisan make:migration create_taches_table     # génère une migration seule

php artisan migrate                                  # exécute les migrations en attente (module 06.5)
php artisan route:list                                 # liste toutes les routes de l'application

php artisan config:clear                                 # vide le cache de configuration (utile après modification de .env)
```

> 💡 `php artisan tinker` est l'équivalent d'un `php -a` (module 01.9) mais avec **toute votre application Laravel déjà chargée** : vous pouvez y tester `App\Models\Tache::count()` directement, sans écrire de script.

## ✅ Points clés à retenir

- `composer create-project laravel/laravel` installe Laravel comme n'importe quelle dépendance Composer.
- Depuis Laravel 11, `bootstrap/app.php` centralise la configuration (routes, middlewares, exceptions) — `Kernel.php` n'existe plus par défaut.
- `.env` remplace vos fichiers de configuration maison ; il n'est jamais versionné.
- `php artisan make:*` génère du code respectant les conventions Laravel — à utiliser systématiquement plutôt que de créer les fichiers à la main.

## ➡️ Pour aller plus loin

- [laravel.com/docs — Installation](https://laravel.com/docs/installation)
- [laravel.com/docs — Artisan Console](https://laravel.com/docs/artisan)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 05 — Outils professionnels](../../05-outils-professionnels/README.md) · **Suite :** [06.2 — Routing et Controllers](../02-routing-controllers/README.md)
