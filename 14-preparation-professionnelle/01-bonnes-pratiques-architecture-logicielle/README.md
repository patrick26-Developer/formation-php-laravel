# 14.1 — Bonnes pratiques d'architecture logicielle

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Synthétiser les principes d'architecture rencontrés tout au long de la formation.
- Savoir reconnaître les signaux qui justifient une évolution d'architecture.
- Éviter les deux excès symétriques : le sur-engineering et la dette technique incontrôlée.
- Argumenter un choix d'architecture face à une équipe ou en entretien.

## 📋 Prérequis

L'intégralité des niveaux 00 à 13.

## ⏱️ Durée estimée

2h de lecture et de réflexion.

## 📖 Théorie

### Ce que vous avez déjà appris, sans toujours le nommer

Cette formation a introduit des principes d'architecture au fil des projets, sans toujours les présenter comme des principes formels. Ce module les nomme et les relie :

| Principe | Où il a été appliqué |
|---|---|
| **Responsabilité unique (SRP)** | `RapportGenerator` (module 12.1) : une seule classe, une méthode publique |
| **Inversion de dépendance (DIP)** | `PaymentGateway` (grands projets 13) : le code métier dépend d'une interface, pas d'une implémentation |
| **Ouvert/fermé (OCP)** | Les Policies (module 07.5) : ajouter une règle d'autorisation n'exige pas de modifier le contrôleur |
| **YAGNI** ("You Aren't Gonna Need It") | Module 08.5 : ne jamais réorganiser en architecture par domaine par anticipation |
| **DRY** ("Don't Repeat Yourself") | Le formulaire Blade partagé `_form.blade.php` (module 06, mini-projet) |
| **Séparation des responsabilités** | MVC (module 03.2), séparation Controller/Service/Repository dans les grands projets |

### Les signaux qui justifient une évolution d'architecture

Une architecture ne se change jamais "parce que c'est mieux en théorie" — toujours en réponse à une **douleur concrète et constatée** :

| Signal observé | Évolution possible |
|---|---|
| Un contrôleur dépasse 150-200 lignes, mélange logique métier et HTTP | Extraire un Service (module 08.4) |
| La même requête `WHERE` complexe copiée dans 4 contrôleurs | Un scope Eloquent (module 07.2) |
| Impossible de tester une classe sans base de données/API réelle | Introduire une interface + injection de dépendance (module 08.4) |
| `app/Models/` et `app/Http/Controllers/` contiennent 50+ fichiers chacun, navigation pénible | Architecture par domaine (module 08.5) — **seulement à cette échelle** |
| Une même règle de validation dupliquée dans 3 endroits | Un Form Request partagé (module 06.6), ou une règle de validation personnalisée |

> ⚠️ **Le sur-engineering est un piège aussi réel que la dette technique.** Un junior anxieux d'être jugé "pas assez pro" introduit parfois des Repository, des interfaces, des Design Patterns sur un CRUD de 3 champs qui n'en a aucun besoin — ajoutant de la complexité sans bénéfice, uniquement pour "avoir l'air sérieux". La bonne question n'est jamais "est-ce que ce pattern est élégant ?" mais "quel problème concret ce pattern résout-il, ici, maintenant ?"

### Un exemple de raisonnement architectural complet

Reprenez le [grand projet SaaS de facturation](../../13-grands-projets/grand-projet-04-saas-facturation/README.md) : pourquoi `PlanLimitService` existe-t-il comme classe séparée, plutôt qu'une méthode sur le modèle `Tenant` ou une vérification directement dans le contrôleur ?

- **Alternative rejetée 1** : vérification dans le contrôleur → dupliquée dès qu'une deuxième ressource limitée par plan (utilisateurs, stockage) apparaît.
- **Alternative rejetée 2** : méthode sur `Tenant` → mélange la responsabilité "représenter un tenant" (le rôle d'un modèle Eloquent) avec "appliquer une règle métier de facturation" — deux responsabilités différentes.
- **Choix retenu** : un Service dédié, injectable, testable indépendamment (comme le prouve `LimitePlanTest`), qui deviendra le point d'extension naturel pour toute future règle de plan.

> 💡 **C'est ce type de raisonnement — comparer des alternatives, identifier le compromis, justifier le choix retenu — qui distingue un développeur senior d'un développeur qui applique des patterns sans les comprendre.** En entretien technique (module 14.3), cette capacité à argumenter est souvent plus valorisée que la solution elle-même.

## ✅ Points clés à retenir

- Chaque principe d'architecture de ce module a déjà été appliqué concrètement dans un projet de la formation — relisez ces projets si un principe reste abstrait.
- Une évolution d'architecture répond toujours à une douleur constatée, jamais à une mode ou une anticipation.
- Le sur-engineering (complexité non justifiée) est un piège aussi réel que la dette technique (complexité mal gérée).
- Savoir comparer des alternatives et justifier un choix architectural est une compétence senior à part entière.

## ➡️ Pour aller plus loin

- *Clean Architecture*, Robert C. Martin
- *A Philosophy of Software Design*, John Ousterhout (sur la notion de complexité "cachée" vs "profonde")

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 13 — Grands projets](../../13-grands-projets/README.md) · **Suite :** [14.2 — Code review et refactoring](../02-code-review-et-refactoring/README.md)
