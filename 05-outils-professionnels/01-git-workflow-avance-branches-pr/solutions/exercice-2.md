# Solution — Exercice 2

```bash
echo "ligne originale" > fichier.txt
git add fichier.txt
git commit -m "Ajoute fichier.txt"

git switch -c feature/a
echo "modification A" > fichier.txt
git commit -am "Modifie la ligne depuis la branche A"

git switch main
git switch -c feature/b
echo "modification B" > fichier.txt
git commit -am "Modifie la ligne depuis la branche B"

git switch main
git merge feature/b   # se fusionne sans problème, main = "modification B"

git merge feature/a
# CONFLICT (content): Merge conflict in fichier.txt
```

Contenu de `fichier.txt` après le conflit :
```
<<<<<<< HEAD
modification B
=======
modification A
>>>>>>> feature/a
```

Résolution (on choisit ici de combiner les deux, à titre d'exemple) :
```bash
# Éditer fichier.txt pour retirer les marqueurs et choisir le contenu final
echo "modification A et B combinées" > fichier.txt
git add fichier.txt
git commit -m "Résout le conflit entre feature/a et feature/b"
```
