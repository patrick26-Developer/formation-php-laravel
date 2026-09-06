# 00.2 — Installation de l'environnement

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Avoir PHP installé et fonctionnel en ligne de commande.
- Avoir Composer (le gestionnaire de dépendances PHP) installé.
- Avoir un éditeur de code configuré pour PHP.
- Savoir lancer un serveur PHP local et exécuter un premier script.

## 📋 Prérequis

[00.1 — Présentation du parcours](../01-presentation-parcours/README.md)

## ⏱️ Durée estimée

30 à 45 minutes (selon votre système d'exploitation).

## 📖 Théorie : de quoi a-t-on besoin ?

Pour développer en PHP puis en Laravel, il faut au minimum :

1. **PHP** (l'interpréteur du langage) — version **8.3 ou supérieure** recommandée pour toute la formation.
2. **Composer** — le gestionnaire de dépendances PHP (l'équivalent de `npm` pour Node.js). Laravel et la quasi-totalité des librairies PHP modernes s'installent via Composer.
3. **Un éditeur de code** — VS Code (gratuit) est recommandé pour cette formation.
4. **Un serveur local** — pour exécuter du PHP dans un navigateur (PHP inclut un serveur de développement intégré, suffisant pour tout le début du parcours).
5. **MySQL/MariaDB** — nécessaire à partir du niveau 02 (PDO). Peut être installé plus tard, ou dès maintenant via un outil tout-en-un.

> 💡 Deux approches possibles : installer chaque outil séparément (ce que ce module détaille), ou utiliser directement **Docker** (vu en détail au [module 05.2](../../05-outils-professionnels/02-docker-fondamentaux/README.md)). Pour débuter, l'installation locale classique est plus simple à comprendre — vous reviendrez à Docker une fois les bases solides.

## 💡 Installation de PHP

### Windows

Deux options recommandées :

- **Laragon** (recommandé pour débuter) : télécharge PHP, MySQL, un serveur web (Nginx/Apache) et phpMyAdmin en un seul paquet. Site officiel : `laragon.org`.
- **Installation manuelle** : télécharger PHP (build "Thread Safe") depuis `windows.php.net/download`, dézipper dans `C:\php`, puis ajouter `C:\php` à la variable d'environnement `PATH`.

Vérifier ensuite dans un terminal (PowerShell) :

```powershell
php -v
```

Vous devez voir s'afficher la version de PHP installée (ex : `PHP 8.3.x`).

### macOS

Avec [Homebrew](https://brew.sh) :

```bash
brew install php
php -v
```

### Linux (Debian/Ubuntu)

```bash
sudo apt update
sudo apt install php-cli php-mbstring php-xml php-curl php-mysql unzip
php -v
```

## 💡 Installation de Composer

Composer s'installe **après** PHP, car c'est un script PHP lui-même.

- **Windows** : télécharger et exécuter `Composer-Setup.exe` depuis `getcomposer.org`.
- **macOS / Linux** :

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

Vérifier l'installation :

```bash
composer -V
```

> ⚠️ Composer est **indispensable** dès le niveau 02 (module 02.7) et pour tout Laravel. Ne sautez pas cette étape même si vous débutez : vous en aurez besoin bientôt.

## 💡 Éditeur de code : VS Code

1. Télécharger VS Code : `code.visualstudio.com`.
2. Installer les extensions recommandées :
   - **PHP Intelephense** — autocomplétion et analyse PHP.
   - **PHP Debug** — débogage pas-à-pas (Xdebug).
   - **Laravel Blade Snippets** — utile à partir du niveau 06.
   - **GitLens** — visualiser l'historique Git directement dans l'éditeur.

## 💡 Lancer son premier script PHP

Créez un fichier `hello.php` :

```php
<?php

echo "Bonjour, PHP !";
```

Exécutez-le en ligne de commande :

```bash
php hello.php
```

Ou lancez le **serveur de développement intégré** de PHP (aucune installation supplémentaire nécessaire) depuis le dossier contenant vos fichiers :

```bash
php -S localhost:8000
```

Puis ouvrez `http://localhost:8000/hello.php` dans votre navigateur.

> 📌 Cette commande `php -S` sera votre meilleure amie pendant tout le niveau 01 : pas besoin d'Apache ou Nginx pour commencer à apprendre.

## 💡 Installer MySQL (pour plus tard, niveau 02+)

- Si vous avez installé **Laragon**, MySQL est déjà inclus et démarré depuis son interface.
- Sinon : télécharger **MySQL Community Server** (`dev.mysql.com/downloads`) ou **MariaDB** (`mariadb.org`).
- Un outil graphique comme **phpMyAdmin** ou **TablePlus** facilite la visualisation des données au début.

## ✅ Points clés à retenir

- `php -v` doit afficher une version ≥ 8.3.
- `composer -V` doit fonctionner : c'est l'outil que vous utiliserez pour **installer les dépendances de chaque projet** de cette formation (`composer install`).
- `php -S localhost:8000` suffit pour tester du code PHP sans serveur web complexe.
- MySQL peut attendre le niveau 02, mais autant l'avoir sous la main dès maintenant si vous avez installé Laragon.

## 🆘 Problèmes fréquents

| Symptôme | Cause probable | Solution |
|---|---|---|
| `php n'est pas reconnu comme une commande` | PHP n'est pas dans le `PATH` | Ajouter le dossier PHP au `PATH` système et rouvrir le terminal |
| `composer n'est pas reconnu` | Composer mal installé ou PATH non rechargé | Réinstaller, ou redémarrer le terminal |
| Extension manquante (`Call to undefined function`) | Extension PHP non activée dans `php.ini` | Décommenter la ligne `extension=...` correspondante dans `php.ini` puis redémarrer le serveur |

## ➡️ Pour aller plus loin

- Documentation officielle PHP : `php.net/manual/fr/`
- Documentation officielle Composer : `getcomposer.org/doc/`
- [ressources/cheatsheets/](../../ressources/cheatsheets/) — aide-mémoire des commandes essentielles

---

**Suite :** [00.3 — Git & GitHub essentiels](../03-git-github-essentiels/README.md)
