# Exercices — 05.1 Git avancé

> Pratiquez dans un dépôt de test dédié (par exemple un dossier vide avec `git init`), pas dans la formation elle-même.

## Exercice 1 — Créer et fusionner une branche (facile)

Créez un dépôt avec un fichier `README.md` et un premier commit sur `main`. Créez une branche `feature/ajout-titre`, modifiez le fichier, committez, puis fusionnez-la dans `main` avec `git merge`.

## Exercice 2 — Provoquer et résoudre un conflit (facile)

Créez une branche `feature/a`, modifiez la ligne 1 d'un fichier, committez. Revenez sur `main`, créez une branche `feature/b`, modifiez la **même ligne** différemment, committez, fusionnez `feature/b` dans `main`. Fusionnez ensuite `feature/a` dans `main` : un conflit doit apparaître. Résolvez-le.

## Exercice 3 — `rebase` d'une branche personnelle (moyen)

Créez une branche, faites 3 commits distincts. Pendant ce temps, ajoutez un commit sur `main` (simulez un collègue). Rebasez votre branche sur `main` (`git rebase main`) et observez avec `git log --oneline --graph --all` la différence par rapport à un `merge` équivalent.

## Exercice 4 — Simuler une Pull Request (moyen)

Sur un vrai dépôt GitHub (public ou privé), poussez une branche de fonctionnalité, ouvrez une Pull Request avec une description structurée (Quoi/Pourquoi/Comment tester), et fusionnez-la depuis l'interface GitHub une fois "review" effectuée (par vous-même si seul).

## Exercice 5 — `git stash` en situation (difficile)

Commencez à modifier un fichier sans committer. Sans perdre ce travail, basculez sur une autre branche, faites-y un commit, revenez, et récupérez vos modifications en cours avec `git stash`. Documentez chaque commande utilisée et son effet observé.

---

Comparez avec [solutions/](solutions/) une fois terminé — chaque solution y est une transcription commentée des commandes attendues.
