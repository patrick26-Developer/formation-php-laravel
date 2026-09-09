# Solution — Exercise 4

```bash
git switch -c feature/exemple-pr
echo "New feature" >> notes.txt
git add notes.txt
git commit -m "Add feature X"

git push -u origin feature/exemple-pr
```

On GitHub:

1. A "feature/exemple-pr had recent pushes" banner directly suggests "Compare & pull request" — click it.
2. PR title: short and descriptive (e.g., "Add user notes management").
3. Structured description, example template:

```markdown
## What
Adds a notes.txt file to store free-form notes.

## Why
Addresses the need expressed in issue #12 to keep track of ideas in progress.

## How to test
1. Pull this branch
2. Check that notes.txt contains the line "New feature"
```

4. Assign a reviewer (or self-approve if working alone, for the exercise).
5. Once "Approve" is given (and CI checks are green if configured, module 05.4), click "Merge pull request".
6. Delete the merged branch (the button GitHub automatically offers) to keep the repository clean.
