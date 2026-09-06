# 05.1 — Git avancé : branches, pull requests, workflow

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Travailler avec des branches Git de façon structurée.
- Comprendre la différence entre `merge` et `rebase`.
- Résoudre des conflits de fusion.
- Créer et faire réviser une Pull Request sur GitHub.

## 📋 Prérequis

[00.3 — Git & GitHub essentiels](../../00-introduction/03-git-github-essentiels/README.md)

## ⏱️ Durée estimée

2h.

## 📖 Théorie

### Pourquoi travailler avec des branches ?

Jusqu'ici (module 00.3), vous avez travaillé directement sur une seule branche (`main`). En équipe — et même seul, sur un projet sérieux — on isole chaque fonctionnalité ou correction dans sa propre **branche**, pour ne jamais risquer de casser le code stable pendant qu'on développe quelque chose de nouveau.

```bash
# Créer une nouvelle branche et basculer dessus immédiatement
git checkout -b feature/authentification

# Équivalent moderne (Git 2.23+)
git switch -c feature/authentification

# Revenir sur main
git switch main

# Lister toutes les branches
git branch
```

> 📌 Convention courante de nommage : `feature/nom-de-la-fonctionnalite`, `fix/nom-du-bug`, `chore/nom-de-la-tache-technique`.

### Le cycle de travail avec une branche

```bash
git switch -c feature/pagination-taches
# ... modifications, ajout, commits ...
git add src/TacheRepository.php
git commit -m "Ajoute la pagination au TacheRepository"

# Récupérer les derniers changements de main pendant que vous travaillez
git switch main
git pull
git switch feature/pagination-taches
git merge main   # ou git rebase main, voir plus bas
```

### `merge` vs `rebase` : deux façons d'intégrer des changements

**`git merge`** crée un nouveau commit qui réunit deux historiques, en conservant leur chronologie exacte (avec des embranchements visibles) :

```bash
git switch feature/pagination-taches
git merge main
```

**`git rebase`** rejoue vos commits **par-dessus** la dernière version de `main`, produisant un historique linéaire, sans commit de fusion :

```bash
git switch feature/pagination-taches
git rebase main
```

| | `merge` | `rebase` |
|---|---|---|
| Historique | Conserve la chronologie réelle, avec embranchements | Linéaire, réécrit l'historique de la branche |
| Sécurité | Ne modifie jamais de commits existants | Réécrit les commits (nouveaux hash) : **ne jamais rebaser une branche déjà partagée/poussée sur laquelle d'autres travaillent** |
| Usage courant | Pour intégrer une feature terminée dans `main` | Pour maintenir sa branche de feature à jour proprement, avant de la partager |

> ⚠️ Règle de sécurité : ne rebasez que des commits qui n'ont **jamais été poussés**, ou uniquement sur une branche personnelle que personne d'autre n'utilise. Rebaser une branche déjà partagée oblige toute l'équipe à un `git pull --force` douloureux.

### Résoudre un conflit de fusion

Un conflit survient quand Git ne peut pas fusionner automatiquement deux modifications sur les mêmes lignes.

```bash
git merge main
# Auto-merging src/TacheRepository.php
# CONFLICT (content): Merge conflict in src/TacheRepository.php
```

Le fichier en conflit contient des marqueurs :

```php
<<<<<<< HEAD
public function lister(string $tri = 'creee_le'): array
=======
public function lister(string $tri = 'titre'): array
>>>>>>> main
```

Il faut choisir (ou combiner) manuellement la bonne version, **supprimer les marqueurs** (`<<<<<<<`, `=======`, `>>>>>>>`), puis :

```bash
git add src/TacheRepository.php
git commit  # finalise la fusion
```

### Pull Request : proposer et faire réviser ses changements

Sur GitHub, une **Pull Request** (PR) propose de fusionner une branche dans une autre, avec un espace de discussion et de revue de code.

```bash
git push -u origin feature/pagination-taches
```

Puis, sur GitHub : "Compare & pull request" → décrire les changements → assigner des relecteurs → attendre l'approbation (et idéalement, que les tests automatiques du [module 05.4](../04-github-actions-ci-cd-fondamentaux/README.md) passent) avant de fusionner.

> 📌 Une bonne description de PR répond à trois questions : **Quoi** (ce qui a changé), **Pourquoi** (le problème résolu ou la fonctionnalité ajoutée), **Comment tester** (les étapes pour vérifier que ça fonctionne).

### `git stash` : mettre de côté un travail en cours

```bash
git stash                  # sauvegarde temporairement les modifications non commitées
git switch main
# ... autre travail urgent ...
git switch feature/pagination-taches
git stash pop               # récupère les modifications mises de côté
```

## ✅ Points clés à retenir

- Une branche par fonctionnalité/correction, jamais de travail direct sur `main` en équipe.
- `merge` préserve l'historique réel ; `rebase` le linéarise, mais ne doit jamais être utilisé sur une branche déjà partagée.
- Un conflit se résout en éditant le fichier, en retirant les marqueurs `<<<`/`===`/`>>>`, puis `git add` + `git commit`.
- Une Pull Request est l'endroit où le code est relu **avant** d'être intégré — jamais un simple formulaire à remplir vite.

## ➡️ Pour aller plus loin

- [git-scm.com/book/fr/v2](https://git-scm.com/book/fr/v2) — le livre de référence Git (gratuit)
- [Module 05.4 — GitHub Actions : fondamentaux CI/CD](../04-github-actions-ci-cd-fondamentaux/README.md)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [Niveau 04 — Bases de données approfondies](../../04-bases-de-donnees-approfondi/README.md) · **Suite :** [05.2 — Docker : les fondamentaux](../02-docker-fondamentaux/README.md)
