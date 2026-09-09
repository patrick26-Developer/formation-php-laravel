# Exercises — 05.1 Advanced Git

> Practice in a dedicated test repository (for example an empty folder with `git init`), not in the training itself.

## Exercise 1 — Create and merge a branch (easy)

Create a repository with a `README.md` file and a first commit on `main`. Create a `feature/ajout-titre` branch, edit the file, commit, then merge it into `main` with `git merge`.

## Exercise 2 — Trigger and resolve a conflict (easy)

Create a `feature/a` branch, edit line 1 of a file, commit. Go back to `main`, create a `feature/b` branch, edit the **same line** differently, commit, merge `feature/b` into `main`. Then merge `feature/a` into `main`: a conflict should appear. Resolve it.

## Exercise 3 — `rebase` of a personal branch (medium)

Create a branch, make 3 separate commits. Meanwhile, add a commit on `main` (simulating a colleague). Rebase your branch onto `main` (`git rebase main`) and observe with `git log --oneline --graph --all` the difference compared to an equivalent `merge`.

## Exercise 4 — Simulate a Pull Request (medium)

On a real GitHub repository (public or private), push a feature branch, open a Pull Request with a structured description (What/Why/How to test), and merge it from the GitHub interface once "reviewed" (by yourself if working alone).

## Exercise 5 — `git stash` in a real situation (hard)

Start editing a file without committing. Without losing this work, switch to another branch, make a commit there, come back, and recover your in-progress changes with `git stash`. Document each command used and its observed effect.

---

Compare with [solutions/](solutions/README.en.md) once done — each solution there is a commented transcript of the expected commands.
