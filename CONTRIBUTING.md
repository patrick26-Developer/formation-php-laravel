# Contribuer à la formation

Merci de vouloir participer à cette formation PHP → Laravel ! Ce document décrit les conventions à respecter pour que le contenu reste cohérent, quel que soit qui l'écrit.

## Structure d'un module de cours

Chaque module (dossier numéroté dans un niveau) suit ce gabarit :

```
NN-nom-du-module/
├── README.md          # Le cours : objectifs, prérequis, théorie, exemples commentés, points clés
├── EXERCICES.md        # Une série d'exercices progressifs (facile → difficile)
├── solutions/           # Corrigés commentés, un fichier par exercice
└── code/                 # (optionnel) Exemples de code exécutables, autonomes
```

Le `README.md` d'un module de cours doit toujours contenir, dans cet ordre :

1. **🎯 Objectifs** — ce que l'apprenant saura faire à la fin
2. **📋 Prérequis** — modules précédents nécessaires
3. **⏱️ Durée estimée**
4. **📖 Théorie** — explications, avec du code commenté
5. **💡 Exemples** — cas concrets
6. **✅ Points clés à retenir**
7. **➡️ Pour aller plus loin** — liens vers la doc officielle

## Kit documentaire d'un projet

Contrairement à un module de cours, un **mini-projet** ou **grand projet** est une application à faire tourner. Chaque projet contient donc un kit documentaire où **chaque fichier a un rôle unique et non redondant** :

| Fichier | Rôle | Contenu attendu |
|---|---|---|
| `README.md` | Vitrine du projet | Objectifs pédagogiques, fonctionnalités, prérequis, aperçu (capture d'écran si pertinent) |
| `INSTALLATION.md` | Mise en place | Cloner/copier le projet, installer les dépendances (`composer install`, `npm install`), configurer `.env`, créer la base de données, lancer les migrations/seeders |
| `EXECUTION.md` | Usage quotidien | Comment démarrer le projet (`php artisan serve`, `docker-compose up`), lancer les tests, les commandes utiles au jour le jour |
| `JOURNAL.md` | Journal de construction | Le déroulé pédagogique **étape par étape** de la construction du projet, dans l'ordre chronologique — permet à l'apprenant de reconstruire le projet lui-même en suivant le même cheminement que l'auteur |
| `RESSOURCES.md` | Aller plus loin | Liens rapides vers la documentation officielle des outils utilisés et les cheatsheets internes pertinentes |

Cette séparation évite qu'un même fichier README mélange "pourquoi ce projet" (pédagogie), "comment l'installer" (setup) et "comment on l'a construit" (démarche) — trois besoins différents pour trois lectures différentes.

## Ton et niveau de langue

- Écrire en **français clair, direct, sans jargon non expliqué**.
- Toujours définir un terme technique la première fois qu'il apparaît dans un module.
- Le code est **toujours commenté** quand il introduit une notion nouvelle.
- Préférer des exemples concrets et progressifs à des explications abstraites.

## Version anglaise

Le français est la langue source. Une version anglaise (`README.en.md` à côté de chaque `README.md`) est ajoutée dans un second temps, une fois le contenu français stabilisé, pour éviter de maintenir deux versions divergentes en parallèle.

## Statuts de contenu

Chaque module affiche un statut dans son `README.md` et dans le [SOMMAIRE.md](SOMMAIRE.md) :

- ✅ **Disponible** — contenu complet et relu
- 🚧 **En cours** — rédaction commencée mais incomplète
- 📋 **Planifié** — structure et objectifs fixés, contenu à écrire

## Licence

Ce projet est sous licence [MIT](LICENSE).
