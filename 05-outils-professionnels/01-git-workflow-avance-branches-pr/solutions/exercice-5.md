# Solution — Exercice 5

```bash
# Modification en cours, NON commitée
echo "travail en cours, pas encore prêt" >> encours.txt

git status
# Affiche "encours.txt" comme fichier non suivi/modifié

git stash
# "Saved working directory and index state WIP on main: ..."
# Le répertoire de travail redevient PROPRE (comme au dernier commit).

git switch autre-branche
echo "correctif urgent" > urgent.txt
git add urgent.txt
git commit -m "Corrige le bug urgent"

git switch main
git stash pop
# Les modifications de encours.txt sont réappliquées, EXACTEMENT comme
# laissées avant le stash.

git status
# encours.txt réapparaît comme modifié/non suivi, prêt à être commité normalement.
```

`git stash list` permet de voir tous les stashs en attente si vous en avez
empilé plusieurs sans les avoir tous récupérés (`git stash pop` ne retire que
le plus récent par défaut).
