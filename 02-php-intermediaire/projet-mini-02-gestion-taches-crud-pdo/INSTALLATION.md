# Installation

## Prérequis

- PHP 8.3+ avec l'extension `pdo_mysql` activée.
- Un serveur MySQL/MariaDB accessible (voir [00.2 — Installation de l'environnement](../../00-introduction/02-installation-environnement/README.md)).
- **Aucune dépendance Composer** pour ce projet (volontaire, voir [README.md](README.md)).

## Étapes

### 1. Créer la base de données

Exécutez le script SQL fourni, par exemple avec le client en ligne de commande MySQL :

```bash
mysql -u root -p < sql/schema.sql
```

Ou copiez/collez son contenu dans phpMyAdmin / votre client SQL habituel.

### 2. Configurer la connexion

Copiez le fichier de configuration modèle :

```bash
cp config.example.php config.php
```

Ouvrez `config.php` et ajustez `db_host`, `db_user`, `db_password` selon votre installation locale (les valeurs par défaut conviennent à une installation Laragon/XAMPP standard avec l'utilisateur `root` sans mot de passe).

> ⚠️ `config.php` est listé dans `.gitignore` : il ne sera jamais versionné, car il pourrait contenir des identifiants sensibles dans un contexte réel.

### 3. Créer un utilisateur de démonstration

```bash
php src/seed.php
```

Ceci crée un compte `demo@example.com` / `demo1234`, en utilisant `password_hash()` — jamais un mot de passe écrit en clair dans un script SQL (voir [module 02.5](../05-sessions-cookies-authentification-maison/README.md)).

### Vérification

Passez à [EXECUTION.md](EXECUTION.md) pour lancer l'application et vous connecter avec ce compte.
