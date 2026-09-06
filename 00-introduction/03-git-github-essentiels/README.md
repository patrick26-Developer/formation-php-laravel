# 00.3 — Git & GitHub essentiels

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre à quoi sert Git et pourquoi tout développeur professionnel l'utilise.
- Savoir initialiser un dépôt, committer, et pousser vers GitHub.
- Connaître le strict minimum de commandes pour suivre cette formation projet par projet.

## 📋 Prérequis

[00.2 — Installation de l'environnement](../02-installation-environnement/README.md)

## ⏱️ Durée estimée

30 minutes.

## 📖 Théorie : pourquoi Git ?

Git est un **système de contrôle de version** : il garde un historique complet de chaque modification de votre code, vous permet de revenir en arrière, de travailler sur des versions parallèles (branches), et de collaborer sans écraser le travail des autres. GitHub est une plateforme qui héberge des dépôts Git en ligne et ajoute des outils de collaboration (Pull Requests, Issues, Actions pour le CI/CD — voir [niveau 05](../../05-outils-professionnels/README.md)).

Dans cette formation, Git sert à deux choses :

1. **Suivre votre propre progression** : chaque exercice, chaque mini-projet peut être commité, ce qui vous donne un historique de votre apprentissage.
2. **Préparer le terrain pour le CI/CD** (niveau 05 et 11), qui repose entièrement sur GitHub.

## 💡 Installation de Git

- **Windows** : `git-scm.com/download/win`
- **macOS** : `brew install git` (ou déjà présent avec Xcode Command Line Tools)
- **Linux** : `sudo apt install git`

Vérifier :

```bash
git --version
```

Configurer votre identité (une seule fois) :

```bash
git config --global user.name "Votre Nom"
git config --global user.email "votre.email@example.com"
```

## 💡 Le cycle Git essentiel

```bash
# 1. Initialiser un dépôt dans un dossier de projet
git init

# 2. Voir l'état des fichiers (modifiés, non suivis...)
git status

# 3. Ajouter des fichiers à l'index (préparer le commit)
git add nom-du-fichier.php
git add .          # ajoute tout le dossier courant

# 4. Créer un commit (un instantané horodaté et commenté)
git commit -m "Ajoute la fonction de calcul de moyenne"

# 5. Voir l'historique des commits
git log --oneline
```

## 💡 Connecter son dépôt local à GitHub

1. Créer un compte sur `github.com` si ce n'est pas déjà fait.
2. Créer un nouveau dépôt vide sur GitHub (sans README, pour éviter les conflits).
3. Lier votre dépôt local :

```bash
git remote add origin https://github.com/votre-utilisateur/nom-du-depot.git
git branch -M main
git push -u origin main
```

Les prochains envois se font simplement avec :

```bash
git push
```

## 💡 Un fichier `.gitignore`

Certains fichiers ne doivent **jamais** être versionnés : dépendances (`vendor/`, `node_modules/`), secrets (`.env`), fichiers générés. On les liste dans un fichier `.gitignore` à la racine du projet. Exemple minimal pour un projet PHP :

```
/vendor/
.env
```

> 📌 Chaque mini-projet et grand projet de cette formation fournira son propre `.gitignore` adapté.

## ✅ Points clés à retenir

- `git init` → `git add` → `git commit` est le cycle de base à répéter à chaque étape de travail.
- Un commit doit avoir un message clair qui explique **pourquoi**, pas juste "update".
- `vendor/` et `.env` ne se committent jamais.
- GitHub sert de sauvegarde distante et de vitrine de votre travail (portfolio).

## 🆘 Problèmes fréquents

| Symptôme | Cause probable | Solution |
|---|---|---|
| `fatal: not a git repository` | Vous n'avez pas lancé `git init` dans ce dossier | Lancer `git init` à la racine du projet |
| `Updates were rejected` au `push` | Le dépôt distant a des commits que vous n'avez pas localement | `git pull --rebase origin main` puis réessayer `git push` |
| Un fichier `.env` a été poussé par erreur | Oublié dans `.gitignore` avant le premier commit | L'ajouter au `.gitignore`, puis `git rm --cached .env` et recommitter |

## ➡️ Pour aller plus loin

- Documentation officielle Git : `git-scm.com/doc`
- [Niveau 05.1 — Git avancé : branches, PR, workflow](../../05-outils-professionnels/01-git-workflow-avance-branches-pr/README.md) (branches, merge, pull requests)

---

**Suite :** [00.4 — Méthodologie d'apprentissage](../04-methodologie-apprentissage/README.md)
