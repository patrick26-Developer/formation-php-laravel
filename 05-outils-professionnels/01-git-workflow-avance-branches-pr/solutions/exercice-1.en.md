# Solution — Exercise 1

```bash
mkdir mon-test-git && cd mon-test-git
git init
echo "# My Project" > README.md
git add README.md
git commit -m "First commit"

git switch -c feature/ajout-titre
echo "## Introduction" >> README.md
git add README.md
git commit -m "Add an introduction section"

git switch main
git merge feature/ajout-titre
# Fast-forward (no commit on main since the branch was created):
# main moves directly to the branch's latest commit.

git log --oneline
```
