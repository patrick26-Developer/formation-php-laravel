# Mini-projet : Gestionnaire de tâches (CRUD PDO)

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Construire une application web complète et réaliste : gestion de tâches personnelles, avec **authentification**, **CRUD complet**, **tri**, **filtre** et **recherche** — en appliquant ensemble tous les modules du Niveau 02, sans aucun framework.

## 📋 Modules mobilisés

- [02.1 à 02.3](../01-poo-bases/README.md) — POO (classes, encapsulation, Singleton)
- [02.4](../04-gestion-exceptions/README.md) — Gestion des exceptions (`PDOException`)
- [02.5](../05-sessions-cookies-authentification-maison/README.md) — Authentification par session
- [02.6](../06-securite-web-fondamentaux/README.md) — Protection CSRF, échappement XSS, requêtes préparées
- [02.7](../07-composer-autoload-psr/README.md) — Organisation du code (ce projet n'utilise pas encore Composer, volontairement, pour bien voir le rôle de chaque `require_once` avant l'automatiser au niveau 03)
- [02.8 et 02.9](../09-crud-complet-pdo-tri-filtre-recherche/README.md) — PDO, Repository, CRUD, tri/filtre/recherche/pagination

## 🧠 Ce que vous allez apprendre

- Assembler authentification, sécurité et CRUD en une application cohérente, plutôt que comme des briques isolées.
- Structurer un projet PHP avec une séparation claire entre logique (`src/`) et interface (`public/`).
- Appliquer le principe **"chaque utilisateur ne voit que ses propres données"** — chaque requête du `TacheRepository` filtre systématiquement par `utilisateur_id`.

## 📂 Structure du projet

```
projet-mini-02-gestion-taches-crud-pdo/
├── README.md              # ce fichier
├── INSTALLATION.md          # mise en place (base de données, config)
├── EXECUTION.md               # lancer et utiliser l'application
├── JOURNAL.md                    # construction étape par étape
├── RESSOURCES.md                    # liens utiles
├── config.example.php                 # modèle de configuration (à copier en config.php)
├── .gitignore                            # ignore config.php (jamais versionné)
├── sql/
│   └── schema.sql                          # création des tables
└── src/
    ├── Database.php                          # connexion PDO (Singleton)
    ├── Auth.php                                # authentification par session
    ├── CsrfHelper.php                            # protection CSRF réutilisable
    ├── TacheRepository.php                         # CRUD + tri/filtre/recherche/pagination
    ├── seed.php                                      # crée un utilisateur de démonstration
    └── public/                                        # point d'entrée web (à servir avec php -S)
        ├── connexion.php
        ├── deconnexion.php
        ├── index.php                                    # liste des tâches (tri/filtre/recherche/pagination)
        ├── creer.php
        ├── modifier.php
        └── supprimer.php
```

## 🚀 Pour commencer

1. Lisez [INSTALLATION.md](INSTALLATION.md) — base de données, configuration, dépendances (aucune dépendance Composer ici).
2. Lisez [EXECUTION.md](EXECUTION.md) pour lancer l'application et vous connecter.
3. **Avant de lire le code fourni**, essayez de construire vous-même `TacheRepository::lister()` avec tri/filtre/recherche, à partir du module 02.9.
4. Consultez [JOURNAL.md](JOURNAL.md) pour voir la démarche complète de construction.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Niveau 03 — PHP Avancé](../../03-php-avance/README.md)
