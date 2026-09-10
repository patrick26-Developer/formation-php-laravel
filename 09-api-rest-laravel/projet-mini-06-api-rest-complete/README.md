# Mini-projet : API REST complète

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Exposer le domaine "petites annonces" (déjà construit avec authentification web au [niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md)) via une **API REST versionnée, authentifiée par jeton, documentée et protégée** — prête à être consommée par une application mobile. C'est la démonstration concrète que la couche métier (modèles, Policies, Form Requests) se réutilise **intégralement** entre une interface web et une API.

## 📋 Modules mobilisés

- [09.1 — Conception d'API RESTful](../01-conception-api-restful-bonnes-pratiques/README.md) (`/api/v1/`, `apiResource`-like)
- [09.2 — API Resources](../02-api-resources-transformers/README.md) (`AnnonceResource`, `whenLoaded`)
- [09.3 — Authentification Sanctum](../03-authentification-api-sanctum/README.md) (jetons personnels)
- [09.5 — Documentation OpenAPI](../05-versioning-documentation-openapi/README.md) (annotations `@OA\*`)
- [09.6 — Rate limiting et sécurité](../06-rate-limiting-securite-api/README.md) (limiteurs différenciés)

## 🧠 Ce que vous allez apprendre

- Réutiliser **sans aucune modification** les modèles, Policies et Form Requests du mini-projet du niveau 07 pour construire une API entièrement différente en surface (JSON, jetons) mais identique en substance (mêmes règles métier).
- Structurer des réponses cohérentes avec les API Resources, y compris les relations (`categorie`, `vendeur`) sans provoquer de N+1.
- Appliquer des limites de débit différenciées selon la sensibilité de chaque route (connexion stricte, lecture publique permissive, écriture authentifiée standard).
- Tester une API avec Pest : authentification, autorisation, structure JSON.

## 📂 Structure du projet

Fichiers à ajouter **par-dessus** le [mini-projet du niveau 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.md) (mêmes modèles `Annonce`/`Category`/`Message`, mêmes `StoreAnnonceRequest`/`UpdateAnnonceRequest`/`AnnoncePolicy`) :

```
projet-mini-06-api-rest-complete/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/V1/    # AuthController, AnnonceController, MessageController
│   │   └── Resources/V1/            # AnnonceResource, CategoryResource, MessageResource
│   └── Providers/AppServiceProvider.php   # limiteurs de débit (api, connexion, lecture-publique)
├── routes/api.php
└── tests/Feature/Api/
    ├── AuthApiTest.php
    └── AnnonceApiTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md) — partir du projet du niveau 07, installer Sanctum, copier ces fichiers.
2. [EXECUTION.md](EXECUTION.md) — tester l'API avec `curl`, lancer les tests Pest.
3. **Avant de lire le code fourni**, essayez de construire vous-même `AnnonceResource` à partir du module 09.2.
4. [JOURNAL.md](JOURNAL.md) — la démarche complète de construction.
5. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Niveau 10 — Fullstack avec Livewire](../../10-fullstack-laravel-livewire/README.md)
