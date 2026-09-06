# Solution — Exercice 1

```bash
mkdir mon-test-git && cd mon-test-git
git init
echo "# Mon Projet" > README.md
git add README.md
git commit -m "Premier commit"

git switch -c feature/ajout-titre
echo "## Introduction" >> README.md
git add README.md
git commit -m "Ajoute une section introduction"

git switch main
git merge feature/ajout-titre
# Fast-forward (aucun commit sur main depuis la création de la branche) :
# main avance directement jusqu'au dernier commit de la branche.

git log --oneline
```
