# Mini-project: Complete REST API

> **Status:** ✅ Available

## 🎯 Learning objective

Expose the "classifieds" domain (already built with web authentication in [level 07](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md)) via a **versioned, token-authenticated, documented, and protected REST API** — ready to be consumed by a mobile app. This is the concrete proof that the business layer (models, Policies, Form Requests) can be **entirely** reused between a web interface and an API.

## 📋 Modules used

- [09.1 — RESTful API Design](../01-conception-api-restful-bonnes-pratiques/README.en.md) (`/api/v1/`, `apiResource`-like)
- [09.2 — API Resources](../02-api-resources-transformers/README.en.md) (`AnnonceResource`, `whenLoaded`)
- [09.3 — Sanctum Authentication](../03-authentification-api-sanctum/README.en.md) (personal access tokens)
- [09.5 — OpenAPI Documentation](../05-versioning-documentation-openapi/README.en.md) (`@OA\*` annotations)
- [09.6 — Rate Limiting and Security](../06-rate-limiting-securite-api/README.en.md) (differentiated limiters)

## 🧠 What you'll learn

- Reuse the level 07 mini-project's models, Policies, and Form Requests **without a single modification** to build an API that's entirely different on the surface (JSON, tokens) but identical in substance (same business rules).
- Structure consistent responses with API Resources, including relationships (`categorie`, `vendeur`) without causing N+1.
- Apply rate limits differentiated by each route's sensitivity (strict login, permissive public reads, standard authenticated writes).
- Test an API with Pest: authentication, authorization, JSON structure.

## 📂 Project structure

Files to add **on top of** the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md) (same `Annonce`/`Category`/`Message` models, same `StoreAnnonceRequest`/`UpdateAnnonceRequest`/`AnnoncePolicy`):

```
projet-mini-06-api-rest-complete/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/V1/    # AuthController, AnnonceController, MessageController
│   │   └── Resources/V1/            # AnnonceResource, CategoryResource, MessageResource
│   └── Providers/AppServiceProvider.php   # rate limiters (api, connexion, lecture-publique)
├── routes/api.php
└── tests/Feature/Api/
    ├── AuthApiTest.php
    └── AnnonceApiTest.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md) — start from the level 07 project, install Sanctum, copy these files.
2. [EXECUTION.md](EXECUTION.en.md) — test the API with `curl`, run the Pest tests.
3. **Before reading the provided code**, try building `AnnonceResource` yourself, based on module 09.2.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process.

**Next in the path:** [Level 10 — Fullstack with Livewire](../../10-fullstack-laravel-livewire/README.en.md)
