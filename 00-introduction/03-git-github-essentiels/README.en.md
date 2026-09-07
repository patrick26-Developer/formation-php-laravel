# 00.3 — Git & GitHub Essentials

> **Status:** ✅ Available

## 🎯 Objectives

- Understand what Git is for and why every professional developer uses it.
- Know how to initialize a repository, commit, and push to GitHub.
- Know the strict minimum of commands needed to follow this training project by project.

## 📋 Prerequisites

[00.2 — Environment Setup](../02-installation-environnement/README.en.md)

## ⏱️ Estimated duration

30 minutes.

## 📖 Theory: why Git?

Git is a **version control system**: it keeps a complete history of every change to your code, lets you go back in time, work on parallel versions (branches), and collaborate without overwriting other people's work. GitHub is a platform that hosts Git repositories online and adds collaboration tools (Pull Requests, Issues, Actions for CI/CD — see [level 05](../../05-outils-professionnels/README.md)).

In this training, Git serves two purposes:

1. **Tracking your own progress**: every exercise, every mini-project can be committed, giving you a history of your learning.
2. **Preparing the ground for CI/CD** (levels 05 and 11), which relies entirely on GitHub.

## 💡 Installing Git

- **Windows**: `git-scm.com/download/win`
- **macOS**: `brew install git` (or already present with Xcode Command Line Tools)
- **Linux**: `sudo apt install git`

Verify:

```bash
git --version
```

Configure your identity (only once):

```bash
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
```

## 💡 The essential Git cycle

```bash
# 1. Initialize a repository in a project folder
git init

# 2. See the state of files (modified, untracked...)
git status

# 3. Stage files (prepare the commit)
git add file-name.php
git add .          # stages the whole current folder

# 4. Create a commit (a timestamped, commented snapshot)
git commit -m "Add the average calculation function"

# 5. View commit history
git log --oneline
```

## 💡 Connecting your local repository to GitHub

1. Create an account on `github.com` if you don't already have one.
2. Create a new, empty repository on GitHub (without a README, to avoid conflicts).
3. Link your local repository:

```bash
git remote add origin https://github.com/your-username/repo-name.git
git branch -M main
git push -u origin main
```

Subsequent pushes are simply done with:

```bash
git push
```

## 💡 A `.gitignore` file

Some files should **never** be version-controlled: dependencies (`vendor/`, `node_modules/`), secrets (`.env`), generated files. These are listed in a `.gitignore` file at the project root. Minimal example for a PHP project:

```
/vendor/
.env
```

> 📌 Every mini-project and large project in this training will provide its own tailored `.gitignore`.

## ✅ Key takeaways

- `git init` → `git add` → `git commit` is the basic cycle to repeat at every step of work.
- A commit should have a clear message explaining **why**, not just "update".
- `vendor/` and `.env` are never committed.
- GitHub serves as a remote backup and a showcase of your work (portfolio).

## 🆘 Common issues

| Symptom | Likely cause | Solution |
|---|---|---|
| `fatal: not a git repository` | You haven't run `git init` in this folder | Run `git init` at the project root |
| `Updates were rejected` on `push` | The remote repository has commits you don't have locally | `git pull --rebase origin main` then retry `git push` |
| A `.env` file was pushed by mistake | Forgotten from `.gitignore` before the first commit | Add it to `.gitignore`, then `git rm --cached .env` and commit again |

## ➡️ Going further

- Official Git documentation: `git-scm.com/doc`
- [Level 05.1 — Advanced Git: branches, PRs, workflow](../../05-outils-professionnels/01-git-workflow-avance-branches-pr/README.md) (branches, merge, pull requests)

---

**Next:** [00.4 — Learning Methodology](../04-methodologie-apprentissage/README.en.md)
