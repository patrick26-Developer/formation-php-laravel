# Solution — Exercise 5

```bash
# Work in progress, NOT committed
echo "work in progress, not ready yet" >> encours.txt

git status
# Shows "encours.txt" as an untracked/modified file

git stash
# "Saved working directory and index state WIP on main: ..."
# The working directory becomes CLEAN again (as of the last commit).

git switch autre-branche
echo "urgent fix" > urgent.txt
git add urgent.txt
git commit -m "Fix the urgent bug"

git switch main
git stash pop
# encours.txt's changes are reapplied, EXACTLY as they were left before
# the stash.

git status
# encours.txt reappears as modified/untracked, ready to be committed normally.
```

`git stash list` lets you see every pending stash if you've stacked
several without recovering them all (`git stash pop` only removes the
most recent one by default).
