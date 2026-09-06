# Installation

## Prérequis

- PHP 8.3+ installé et accessible en ligne de commande (`php -v` fonctionne). Voir [00.2 — Installation de l'environnement](../../00-introduction/02-installation-environnement/README.md) si ce n'est pas encore le cas.
- **Aucune dépendance externe** : ce projet n'utilise pas Composer, il ne s'agit que de PHP natif.

## Mise en place

1. Copiez ou clonez ce dossier `projet-mini-01-calculatrice-cli-et-web/` sur votre machine.
2. Aucune installation supplémentaire n'est nécessaire — pas de `composer install`, pas de fichier `.env`, pas de base de données pour ce projet.

## Vérification

Depuis le dossier du projet, lancez :

```bash
php src/cli.php 4 + 4
```

Si vous obtenez `4 + 4 = 8`, l'installation est fonctionnelle.

**Suite :** [EXECUTION.md](EXECUTION.md)
