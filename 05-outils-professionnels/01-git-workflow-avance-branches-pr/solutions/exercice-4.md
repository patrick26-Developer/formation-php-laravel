# Solution — Exercice 4

```bash
git switch -c feature/exemple-pr
echo "Nouvelle fonctionnalité" >> notes.txt
git add notes.txt
git commit -m "Ajoute la fonctionnalité X"

git push -u origin feature/exemple-pr
```

Sur GitHub :

1. Une bannière "feature/exemple-pr had recent pushes" propose directement "Compare & pull request" — cliquez.
2. Titre de la PR : court et descriptif (ex : "Ajoute la gestion des notes utilisateur").
3. Description structurée, exemple de gabarit :

```markdown
## Quoi
Ajoute un fichier notes.txt permettant de stocker des notes libres.

## Pourquoi
Répond au besoin exprimé dans l'issue #12 de garder une trace des idées en cours.

## Comment tester
1. Récupérer cette branche
2. Vérifier que notes.txt contient bien la ligne "Nouvelle fonctionnalité"
```

4. Assignez un relecteur (ou auto-approuvez si vous travaillez seul, pour l'exercice).
5. Une fois "Approve" donné (et les checks CI verts si configurés, module 05.4), cliquez sur "Merge pull request".
6. Supprimez la branche fusionnée (bouton proposé automatiquement par GitHub) pour garder le dépôt propre.
