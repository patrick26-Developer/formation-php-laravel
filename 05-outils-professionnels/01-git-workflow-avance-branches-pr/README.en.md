# 05.1 — Advanced Git: Branches, Pull Requests, Workflow

> **Status:** ✅ Available

## 🎯 Objectives

- Work with Git branches in a structured way.
- Understand the difference between `merge` and `rebase`.
- Resolve merge conflicts.
- Create and get a Pull Request reviewed on GitHub.

## 📋 Prerequisites

[00.3 — Git & GitHub Essentials](../../00-introduction/03-git-github-essentiels/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Why work with branches?

Until now (module 00.3), you've worked directly on a single branch (`main`). In a team — and even alone, on a serious project — every feature or fix is isolated in its own **branch**, so you never risk breaking stable code while developing something new.

```bash
# Create a new branch and switch to it immediately
git checkout -b feature/authentication

# Modern equivalent (Git 2.23+)
git switch -c feature/authentication

# Go back to main
git switch main

# List all branches
git branch
```

> 📌 Common naming convention: `feature/feature-name`, `fix/bug-name`, `chore/technical-task-name`.

### The workflow with a branch

```bash
git switch -c feature/task-pagination
# ... changes, staging, commits ...
git add src/TacheRepository.php
git commit -m "Add pagination to TacheRepository"

# Pull the latest changes from main while you work
git switch main
git pull
git switch feature/task-pagination
git merge main   # or git rebase main, see below
```

### `merge` vs `rebase`: two ways to integrate changes

**`git merge`** creates a new commit that joins two histories together, preserving their exact chronology (with visible branching points):

```bash
git switch feature/task-pagination
git merge main
```

**`git rebase`** replays your commits **on top of** the latest version of `main`, producing a linear history with no merge commit:

```bash
git switch feature/task-pagination
git rebase main
```

| | `merge` | `rebase` |
|---|---|---|
| History | Preserves the real chronology, with branching points | Linear, rewrites the branch's history |
| Safety | Never modifies existing commits | Rewrites commits (new hashes): **never rebase a branch that's already been shared/pushed and that others are working on** |
| Common use | To integrate a finished feature into `main` | To cleanly keep your feature branch up to date, before sharing it |

> ⚠️ Safety rule: only rebase commits that have **never been pushed**, or only on a personal branch nobody else uses. Rebasing an already-shared branch forces the whole team into a painful `git pull --force`.

### Resolving a merge conflict

A conflict occurs when Git can't automatically merge two changes on the same lines.

```bash
git merge main
# Auto-merging src/TacheRepository.php
# CONFLICT (content): Merge conflict in src/TacheRepository.php
```

The conflicted file contains markers:

```php
<<<<<<< HEAD
public function lister(string $tri = 'creee_le'): array
=======
public function lister(string $tri = 'titre'): array
>>>>>>> main
```

You need to manually choose (or combine) the right version, **remove the markers** (`<<<<<<<`, `=======`, `>>>>>>>`), then:

```bash
git add src/TacheRepository.php
git commit  # finalizes the merge
```

### Pull Request: proposing and getting your changes reviewed

On GitHub, a **Pull Request** (PR) proposes merging one branch into another, with a space for discussion and code review.

```bash
git push -u origin feature/task-pagination
```

Then, on GitHub: "Compare & pull request" → describe the changes → assign reviewers → wait for approval (and ideally, for the automated tests from [module 05.4](../04-github-actions-ci-cd-fondamentaux/README.md) to pass) before merging.

> 📌 A good PR description answers three questions: **What** (what changed), **Why** (the problem solved or the feature added), **How to test** (the steps to verify it works).

### `git stash`: setting aside work in progress

```bash
git stash                  # temporarily saves uncommitted changes
git switch main
# ... other urgent work ...
git switch feature/task-pagination
git stash pop               # restores the set-aside changes
```

## ✅ Key takeaways

- One branch per feature/fix, never working directly on `main` as a team.
- `merge` preserves real history; `rebase` linearizes it, but must never be used on an already-shared branch.
- A conflict is resolved by editing the file, removing the `<<<`/`===`/`>>>` markers, then `git add` + `git commit`.
- A Pull Request is where code gets reviewed **before** being merged — never just a form to fill out quickly.

## ➡️ Going further

- [git-scm.com/book/en/v2](https://git-scm.com/book/en/v2) — the reference Git book (free)
- [Module 05.4 — GitHub Actions: CI/CD Fundamentals](../04-github-actions-ci-cd-fondamentaux/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [Level 04 — Databases in Depth](../../04-bases-de-donnees-approfondi/README.en.md) · **Next:** [05.2 — Docker: The Fundamentals](../02-docker-fondamentaux/README.md) *(French only)*
