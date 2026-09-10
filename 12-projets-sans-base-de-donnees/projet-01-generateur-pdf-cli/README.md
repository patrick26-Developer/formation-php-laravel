# Projet : Générateur de PDF en ligne de commande

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Montrer que PHP reste pleinement pertinent **sans base de données** : un outil CLI qui lit un fichier CSV local et génère un rapport PDF, en réutilisant uniquement les compétences des niveaux 01 (fichiers) et 03 (Composer, tests, architecture propre).

## 📋 Modules mobilisés

- [01.8 — Fichiers, includes et organisation](../../01-php-fondamentaux/08-fichiers-et-includes/README.md) (lecture de CSV)
- [02.7 — Composer, autoload, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.md) (dépendance `dompdf/dompdf`)
- [03.3 — Tests unitaires avec PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.md)
- [03.5 — Bonnes pratiques, PSR-12 et Clean Code](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.md) (une seule responsabilité : `RapportGenerator` ne fait QUE générer, la lecture CSV et la conversion PDF sont des méthodes privées bien séparées)

## 🧠 Ce que vous allez apprendre

- Utiliser une dépendance Composer tierce (`dompdf/dompdf`) pour une tâche que PHP ne sait pas faire nativement.
- Lire et parser un fichier CSV avec les fonctions natives (`fopen`, `fgetcsv`).
- Échapper systématiquement les données avant de les injecter dans du HTML, même dans un contexte "interne" (génération de PDF) où l'on pourrait être tenté de négliger cette protection.
- Tester une classe qui produit un fichier binaire (PDF), en vérifiant sa signature plutôt que son contenu exact.

## 📂 Structure du projet

```
projet-01-generateur-pdf-cli/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── composer.json
├── src/RapportGenerator.php
├── bin/generer-rapport.php
├── donnees/ventes.csv
└── tests/RapportGeneratorTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md).
2. [EXECUTION.md](EXECUTION.md).
3. [JOURNAL.md](JOURNAL.md) — la démarche de construction.
4. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Projet : Consommation d'une API externe](../projet-02-api-consommation-externe/README.md)
