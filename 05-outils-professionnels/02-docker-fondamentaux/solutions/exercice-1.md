# Solution — Exercice 1

```bash
docker run php:8.3-cli php -v
```
Affiche la version de PHP, puis le conteneur se termine immédiatement
(la commande `php -v` s'exécute et rend la main).

```bash
docker run -it php:8.3-cli php -a
```
`-it` (interactif + pseudo-terminal) garde le conteneur ouvert et connecté à
votre terminal : `php -a` lance le mode interactif de PHP (un REPL), où vous
pouvez taper du code PHP ligne par ligne et voir le résultat immédiatement.
Tapez `exit` ou `Ctrl+D` pour quitter et arrêter le conteneur.

Différence clé : sans `-it`, un conteneur exécute sa commande puis s'arrête
dès qu'elle est terminée — pas d'interaction possible.
