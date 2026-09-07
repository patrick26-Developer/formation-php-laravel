# 14.3 — Préparation aux entretiens techniques

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Connaître les formats d'entretien technique PHP/Laravel les plus courants.
- Préparer des réponses structurées aux questions classiques.
- S'entraîner sur des exercices d'algorithmie typiques, sans dépendre d'un framework.
- Savoir présenter un projet de portfolio (les grands projets du niveau 13) de façon convaincante.

## 📋 Prérequis

L'intégralité des niveaux 00 à 13.

## ⏱️ Durée estimée

3h, à répartir sur plusieurs sessions d'entraînement.

## 📖 Théorie

### Les formats d'entretien technique courants

| Format | À quoi s'attendre | Comment s'y préparer |
|---|---|---|
| **Questions de connaissance** | "Quelle différence entre `bind` et `singleton` ?" (module 08.4) | Relire les modules "Points clés à retenir" de cette formation |
| **Exercice de code en direct (live coding)** | Résoudre un petit problème algorithmique au tableau/partagé à l'écran | S'entraîner à voix haute, expliquer son raisonnement en même temps que l'on code |
| **Revue de code** | Critiquer un extrait de code fourni | Réutiliser la grille de lecture du [module 14.2](../02-code-review-et-refactoring/README.md) |
| **Présentation de projet** | Présenter un projet personnel (portfolio) | Préparer une présentation de 3-5 minutes par grand projet du niveau 13 |
| **Système design / architecture** | "Comment concevriez-vous un système de X ?" | S'entraîner à poser des questions de clarification AVANT de proposer une solution |

### Questions de connaissance classiques, avec un pointeur vers le module correspondant

- *"Expliquez le cycle de vie d'une requête Laravel."* → [module 06.1](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.md) (routing), [module 07.3](../../07-laravel-intermediaire/03-middlewares-form-requests/README.md) (middlewares).
- *"Comment évitez-vous le problème N+1 ?"* → [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.md) (`with()`, `whenLoaded()`).
- *"Différence entre authentification et autorisation ?"* → [module 07.5](../../07-laravel-intermediaire/05-autorisations-policies-gates/README.md).
- *"Comment protégez-vous contre l'injection SQL ?"* → [module 02.6](../../02-php-intermediaire/06-securite-web-fondamentaux/README.md) (requêtes préparées).
- *"Qu'est-ce qu'une transaction et quand l'utiliser ?"* → [module 04.2](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.md), illustré au [grand projet e-commerce](../../13-grands-projets/grand-projet-02-ecommerce-minimal/README.md).
- *"Comment testez-vous une file d'attente sans l'exécuter réellement ?"* → [module 08.3](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.md) (`Queue::fake()`).

> 💡 Une bonne réponse ne récite jamais une définition apprise par cœur — elle **illustre avec un exemple concret**, idéalement tiré d'un projet réellement construit. "J'ai rencontré ce problème précisément dans mon projet SaaS, où..." est toujours plus convaincant que "En théorie, on devrait...".

### La méthode STAR pour les questions comportementales

Un entretien technique inclut souvent des questions non-techniques ("Racontez-moi un bug difficile que vous avez résolu"). La méthode **STAR** structure une réponse :

- **S**ituation : le contexte (quel projet, quel problème).
- **T**âche : ce qui était attendu de vous.
- **A**ction : ce que vous avez concrètement fait.
- **R**ésultat : l'issue, idéalement mesurable.

> 📌 Exemple concret réutilisable de cette formation : *"Dans mon projet SaaS multi-tenant (Situation), je devais garantir qu'aucune fuite de données n'était possible entre organisations (Tâche). J'ai implémenté un scope global Eloquent doublé d'une suite de tests dédiée à l'isolation (Action). Les tests ont révélé qu'une requête Query Builder brute contournait le scope — j'ai documenté cette limite et établi une règle d'équipe (Résultat)."* — directement inspiré du [module 08.5](../../08-laravel-avance/05-architecture-modulaire/README.md).

### Présenter un projet de portfolio en 3-5 minutes

1. **Le problème** (30s) : quel besoin ce projet résout-il ?
2. **Les choix techniques clés** (2 min) : 2-3 décisions d'architecture intéressantes, PAS une liste exhaustive de technologies utilisées.
3. **Une difficulté rencontrée et sa résolution** (1 min) : montre la capacité à raisonner, pas seulement à suivre un tutoriel.
4. **Ce que vous feriez différemment** (30s) : montre le recul critique, une qualité très valorisée.

> 💡 Le `JOURNAL.md` de chaque grand projet du [niveau 13](../../13-grands-projets/README.md) est **directement réutilisable** comme support de préparation à cet exercice : chaque étape y explique déjà le "pourquoi" d'une décision, exactement la matière première d'une bonne présentation de portfolio.

## ✅ Points clés à retenir

- Illustrer une réponse théorique avec un exemple concret vécu est toujours plus convaincant qu'une définition récitée.
- La méthode STAR structure une réponse comportementale de façon claire et complète.
- Une présentation de projet doit mettre en avant les décisions et les difficultés, pas une liste de technologies.
- Les `JOURNAL.md` des projets de cette formation sont une préparation directe à l'entretien technique.

## ➡️ Pour aller plus loin

- [github.com/kdn251/interviews](https://github.com/kdn251/interviews) (structures de données et algorithmes, généraliste)
- Relire le [SOMMAIRE.md](../../SOMMAIRE.md) complet pour repérer les modules à réviser en priorité selon vos points faibles perçus.

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [14.2 — Code review et refactoring](../02-code-review-et-refactoring/README.md) · **Suite :** [14.4 — Veille technologique et écosystème PHP/Laravel](../04-veille-et-ecosysteme-php-laravel/README.md)
