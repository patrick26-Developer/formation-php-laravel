# Solution — Exercice 3

```bash
git switch -c feature/trois-commits
echo "A" >> travail.txt && git add travail.txt && git commit -m "Commit 1"
echo "B" >> travail.txt && git commit -am "Commit 2"
echo "C" >> travail.txt && git commit -am "Commit 3"

# Simuler un collègue qui avance main pendant ce temps
git switch main
echo "changement collègue" > autre-fichier.txt
git add autre-fichier.txt
git commit -m "Commit du collègue sur main"

git switch feature/trois-commits
git rebase main
# Git rejoue les 3 commits de la branche, un par un, PAR-DESSUS le nouveau
# commit de main. Les 3 commits obtiennent de NOUVEAUX hash (ce sont
# techniquement de nouveaux commits, même si leur contenu est identique).

git log --oneline --graph --all
# Résultat : une ligne droite unique, main -> commit collègue -> commit 1
# -> commit 2 -> commit 3. Aucun embranchement visible.
```

Comparaison avec un `merge` équivalent (à tester séparément, en repartant
d'un état identique) : `git merge main` depuis la branche produirait un
commit de fusion supplémentaire, et `git log --graph` afficherait un
embranchement visible (la branche et main divergent puis se rejoignent),
au lieu de la ligne unique obtenue avec `rebase`.
