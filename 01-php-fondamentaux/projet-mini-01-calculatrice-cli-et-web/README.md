# Mini-projet : Calculatrice CLI et Web

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Appliquer ensemble les notions du Niveau 01 (fonctions typées, `match`, gestion d'erreurs avec exceptions, formulaires HTML, arguments en ligne de commande) en construisant **une seule logique de calcul réutilisée par deux interfaces différentes** : une en ligne de commande (CLI) et une dans un navigateur (Web).

## 📋 Modules mobilisés

- [01.2 — Opérateurs et structures de contrôle](../02-operateurs-structures-controle/README.md) (`match`)
- [01.4 — Fonctions et portée des variables](../04-fonctions/README.md) (fonctions typées)
- [01.7 — Formulaires HTML et GET/POST](../07-formulaires-http-get-post/README.md)
- [01.9 — Introduction à la gestion d'erreurs](../09-gestion-erreurs-debutant/README.md) (exceptions)

## 🧠 Ce que vous allez apprendre

- Séparer la **logique métier** (le calcul) de ses **interfaces** (CLI, Web) pour ne pas dupliquer de code — un principe qui reviendra à chaque niveau de cette formation, jusqu'à l'architecture MVC (niveau 03) et Laravel.
- Lire des arguments passés en ligne de commande (`$argv`).
- Gérer proprement une erreur métier (division par zéro) avec des exceptions, dans deux contextes d'affichage différents (terminal, HTML).

## 📂 Structure du projet

```
projet-mini-01-calculatrice-cli-et-web/
├── README.md          # ce fichier
├── INSTALLATION.md      # comment mettre en place le projet
├── EXECUTION.md          # comment le lancer et l'utiliser
├── JOURNAL.md             # comment il a été construit, étape par étape
├── RESSOURCES.md           # liens utiles
└── src/
    ├── Calculatrice.php    # logique de calcul partagée (fonctions calculer/diviser)
    ├── cli.php               # point d'entrée ligne de commande
    └── web/
        └── index.php          # point d'entrée web (formulaire HTML)
```

## 🚀 Pour commencer

1. Lisez [INSTALLATION.md](INSTALLATION.md) pour mettre en place le projet (aucune dépendance externe ici, juste PHP).
2. Lisez [EXECUTION.md](EXECUTION.md) pour lancer les deux interfaces.
3. **Avant de lire le code fourni**, essayez de recoder vous-même `src/Calculatrice.php` à partir des modules du niveau 01.
4. Consultez [JOURNAL.md](JOURNAL.md) pour voir comment ce projet a été construit dans l'ordre, et comparez avec votre propre démarche.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Niveau 02 — PHP Intermédiaire](../../02-php-intermediaire/README.md)
