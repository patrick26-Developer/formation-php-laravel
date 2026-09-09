# Solution — Exercise 3

```bash
git switch -c feature/trois-commits
echo "A" >> travail.txt && git add travail.txt && git commit -m "Commit 1"
echo "B" >> travail.txt && git commit -am "Commit 2"
echo "C" >> travail.txt && git commit -am "Commit 3"

# Simulate a colleague advancing main in the meantime
git switch main
echo "colleague's change" > autre-fichier.txt
git add autre-fichier.txt
git commit -m "Colleague's commit on main"

git switch feature/trois-commits
git rebase main
# Git replays the branch's 3 commits, one by one, ON TOP OF main's new
# commit. The 3 commits get NEW hashes (they're technically new commits,
# even though their content is identical).

git log --oneline --graph --all
# Result: a single straight line, main -> colleague's commit -> commit 1
# -> commit 2 -> commit 3. No visible branching.
```

Comparison with an equivalent `merge` (to test separately, starting from
an identical state): `git merge main` from the branch would produce an
extra merge commit, and `git log --graph` would show visible branching
(the branch and main diverge then rejoin), instead of the single line
obtained with `rebase`.
