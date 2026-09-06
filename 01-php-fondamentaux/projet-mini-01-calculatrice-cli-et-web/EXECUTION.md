# Exécution

## Interface en ligne de commande (CLI)

Depuis la racine du projet :

```bash
php src/cli.php <nombre1> <operation> <nombre2>
```

Exemples :

```bash
php src/cli.php 10 + 5     # 10 + 5 = 15
php src/cli.php 20 / 4     # 20 / 4 = 5
php src/cli.php 8 / 0      # Erreur : Division par zéro impossible.
```

Codes de sortie : `0` en cas de succès, `1` en cas d'erreur (arguments manquants, opération invalide, division par zéro) — utile si vous appelez ce script depuis un autre programme ou un pipeline.

## Interface Web

Depuis le dossier `src/web/`, lancez le serveur PHP intégré :

```bash
cd src/web
php -S localhost:8000
```

Puis ouvrez `http://localhost:8000` dans votre navigateur. Remplissez le formulaire et cliquez sur "Calculer".

## Tester les cas d'erreur

- CLI : `php src/cli.php 10 % 5` → message d'erreur "Opération inconnue".
- Web : entrez `abc` dans un champ nombre → message "Les deux valeurs doivent être des nombres."
- Les deux : tentez une division par 0 → message d'erreur cohérent dans les deux interfaces, car elles partagent la même fonction `diviser()`.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour comprendre comment ce comportement partagé a été construit.
