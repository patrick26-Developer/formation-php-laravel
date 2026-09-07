# Aide-mémoire Git

## Cycle de base

```bash
git init
git status
git add fichier.php          # git add .   (tout le dossier courant)
git commit -m "Message clair au présent, décrivant le POURQUOI"
git log --oneline
```

## Branches

```bash
git branch                       # lister
git checkout -b feature/x          # créer et basculer
git checkout main                    # basculer
git merge feature/x                    # fusionner feature/x DANS la branche courante
git branch -d feature/x                  # supprimer (après fusion)
```

## Distant (remote)

```bash
git remote add origin <url>
git push -u origin main
git push
git pull
git fetch                    # récupère sans fusionner
```

## Annuler / corriger

```bash
git restore fichier.php              # annule les modifications NON commitées d'un fichier
git reset --soft HEAD~1                # annule le dernier commit, garde les changements en attente
git revert <hash>                        # crée un NOUVEAU commit qui annule un commit passé (sûr sur du code partagé)
git stash / git stash pop                  # met de côté temporairement des changements non commités
```

## Résoudre un conflit de fusion

```bash
git merge autre-branche
# Éditer les fichiers marqués <<<<<<< / ======= / >>>>>>>
git add fichier-resolu.php
git commit
```

## Pull Request (workflow GitHub)

```bash
git checkout -b feature/ma-fonctionnalite
# ... commits ...
git push -u origin feature/ma-fonctionnalite
gh pr create --title "..." --body "..."
```

## Bonnes pratiques

- Un commit = un changement logique cohérent, pas "fin de journée".
- Jamais de `--force` sur une branche partagée sans prévenir l'équipe.
- `.gitignore` avant le premier commit (`vendor/`, `.env`, `node_modules/`).

**Voir aussi :** [00.3 — Git & GitHub essentiels](../../00-introduction/03-git-github-essentiels/README.md), [05.1 — Git avancé](../../05-outils-professionnels/01-git-workflow-avance-branches-pr/README.md)
