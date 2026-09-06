# Commandes — Exercice 3

```bash
docker build -t ma-calculatrice .

docker run ma-calculatrice 10 + 5    # 10 + 5 = 15
docker run ma-calculatrice 20 / 4    # 20 / 4 = 5
docker run ma-calculatrice 8 / 0     # Erreur : Division par zéro impossible.
```

Avec `CMD` (exercice 2), `docker run ma-calculatrice 20 / 4` aurait
REMPLACÉ toute la commande par défaut par "20 / 4" tel quel (interprété
comme une commande shell invalide), plutôt que de l'ajouter aux arguments
de `php src/cli.php`. `ENTRYPOINT` est le bon choix dès qu'on veut qu'un
conteneur se comporte comme un exécutable acceptant des arguments variables.
