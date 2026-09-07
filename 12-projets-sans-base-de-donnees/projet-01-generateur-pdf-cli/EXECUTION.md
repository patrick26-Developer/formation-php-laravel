# Exécution

## Générer un rapport

```bash
php bin/generer-rapport.php donnees/ventes.csv "Rapport des ventes" sortie/rapport.pdf
```

```
Rapport généré avec succès : sortie/rapport.pdf
```

Ouvrez `sortie/rapport.pdf` avec n'importe quel lecteur PDF : un tableau reprenant les colonnes du CSV, avec la date de génération en en-tête.

## Générer un rapport avec vos propres données

Remplacez `donnees/ventes.csv` par n'importe quel fichier CSV (première ligne = en-têtes de colonnes) :

```bash
php bin/generer-rapport.php mon-fichier.csv "Mon rapport" sortie/mon-rapport.pdf
```

## Gestion des erreurs

```bash
php bin/generer-rapport.php fichier-inexistant.csv "Test" sortie/x.pdf
```
```
Erreur : Fichier introuvable ou illisible : fichier-inexistant.csv
```
(code de sortie 1, exploitable dans un script shell/CI)

## Lancer les tests

```bash
composer test
```

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
