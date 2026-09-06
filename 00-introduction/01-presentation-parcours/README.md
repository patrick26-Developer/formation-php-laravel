# 00.1 — Présentation du parcours

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre la philosophie et la structure de la formation.
- Savoir comment naviguer entre niveaux, modules et projets.
- Comprendre ce qu'on attend de vous à chaque étape.

## 📋 Prérequis

Aucun. C'est le tout premier module.

## ⏱️ Durée estimée

15 minutes de lecture.

## 📖 Pourquoi cette formation existe

Il existe des centaines de tutoriels PHP et Laravel sur internet, mais peu de parcours qui vont **du premier `echo "Hello World";` jusqu'à la construction d'un SaaS multi-tenant avec API, tests et pipeline CI/CD**, en gardant la même cohérence pédagogique tout du long. C'est l'objectif de ce dépôt : être une référence unique, gratuite, et suffisamment complète pour qu'on n'ait pas besoin d'aller chercher ailleurs les fondamentaux.

## 📖 La structure en 15 niveaux

La formation est découpée en niveaux numérotés de `00` à `14`. Ils sont conçus pour être suivis **dans l'ordre** la première fois :

1. **00 — Introduction** *(vous êtes ici)* : mise en place.
2. **01 à 03 — PHP** : des fondamentaux (variables, boucles, fonctions) jusqu'au PHP avancé (POO, design patterns, mini-framework maison, API native). On construit d'abord sa propre compréhension du langage **sans framework**, pour ne jamais dépendre de la "magie" de Laravel sans savoir ce qu'il y a dessous.
3. **04 et 05 — Transversal** : bases de données approfondies et outils professionnels (Git avancé, Docker, CI/CD, qualité de code). Ces compétences serviront pour tout le reste du parcours.
4. **06 à 10 — Laravel** : du Laravel débutant jusqu'à la construction d'API REST complètes et d'applications fullstack avec Livewire.
5. **11 — DevOps avancé** : dockeriser et déployer une vraie application Laravel, avec un pipeline CI/CD complet.
6. **12 et 13 — Projets** : des projets sans base de données (pour varier les compétences) et des grands projets "portfolio" complets.
7. **14 — Préparation professionnelle** : architecture, code review, entretiens techniques, veille.

## 📖 Comment est construit un module

Chaque module de cours (dans les niveaux 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 14) contient :

- Un **`README.md`** : le cours en lui-même — objectifs, théorie, exemples de code commentés, points clés.
- Un **`EXERCICES.md`** : des exercices à faire vous-même, du plus facile au plus difficile.
- Un dossier **`solutions/`** : les corrigés commentés — à consulter **après** avoir essayé, pas avant.

## 📖 Comment est construit un projet (mini ou grand)

Les niveaux 01, 02, 03, 06, 07, 08, 09, 10, 12 et 13 contiennent des **projets pratiques**. Un projet n'est pas un simple exercice : c'est une petite application complète à faire tourner sur votre machine. Chaque projet contient donc un **kit documentaire** de 5 fichiers, chacun avec un rôle précis :

| Fichier | Répond à la question... |
|---|---|
| `README.md` | *"Pourquoi ce projet et qu'est-ce que ça fait ?"* |
| `INSTALLATION.md` | *"Comment je mets ça en route sur ma machine ?"* |
| `EXECUTION.md` | *"Comment je le lance et je l'utilise au quotidien ?"* |
| `JOURNAL.md` | *"Comment a-t-il été construit, étape par étape ?"* |
| `RESSOURCES.md` | *"Où je trouve plus d'infos si je veux creuser ?"* |

Cette séparation est volontaire : quand vous cherchez "comment installer les dépendances", vous n'avez pas envie de scroller à travers la présentation pédagogique du projet. Chaque fichier va droit au but.

## ✅ Points clés à retenir

- La formation se suit **dans l'ordre**, niveau par niveau.
- Un module = cours + exercices + solutions.
- Un projet = application complète + kit documentaire à 5 fichiers.
- Le [SOMMAIRE.md](../../SOMMAIRE.md) à la racine est votre carte : toujours y revenir si vous êtes perdu.

## ➡️ Pour aller plus loin

- [SOMMAIRE.md](../../SOMMAIRE.md) — la table des matières complète
- [CONTRIBUTING.md](../../CONTRIBUTING.md) — si vous voulez contribuer à la formation

---

**Suite :** [00.2 — Installation de l'environnement](../02-installation-environnement/README.md)
