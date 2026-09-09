# Solution — Exercise 2

```bash
echo "original line" > fichier.txt
git add fichier.txt
git commit -m "Add fichier.txt"

git switch -c feature/a
echo "modification A" > fichier.txt
git commit -am "Change the line from branch A"

git switch main
git switch -c feature/b
echo "modification B" > fichier.txt
git commit -am "Change the line from branch B"

git switch main
git merge feature/b   # merges without issue, main = "modification B"

git merge feature/a
# CONFLICT (content): Merge conflict in fichier.txt
```

Content of `fichier.txt` after the conflict:
```
<<<<<<< HEAD
modification B
=======
modification A
>>>>>>> feature/a
```

Resolution (here we choose to combine both, as an example):
```bash
# Edit fichier.txt to remove the markers and pick the final content
echo "modification A and B combined" > fichier.txt
git add fichier.txt
git commit -m "Resolve the conflict between feature/a and feature/b"
```
