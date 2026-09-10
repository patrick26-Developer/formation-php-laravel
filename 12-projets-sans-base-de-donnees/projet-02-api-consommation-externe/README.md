# Projet : Consommation d'une API externe

> **Statut :** ✅ Disponible

## 🎯 Objectif pédagogique

Consommer une API HTTP tierce (météo, sans clé requise) avec un **cache fichier local** — sans base de données — et tester le client HTTP sans jamais effectuer de vrai appel réseau pendant les tests.

## 📋 Modules mobilisés

- [02.7 — Composer, autoload, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.md) (dépendance `guzzlehttp/guzzle`)
- [08.2 — Cache et optimisation de performance](../../08-laravel-avance/02-cache-optimisation-performance/README.md) (principe du cache, ici sans Laravel)
- [03.3 — Tests unitaires avec PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.md) (mock d'un client HTTP)
- [02.4 — Gestion des exceptions](../../02-php-intermediaire/04-gestion-exceptions/README.md)

## 🧠 Ce que vous allez apprendre

- Utiliser Guzzle, le client HTTP standard de l'écosystème PHP, pour interroger une API REST externe.
- Implémenter un cache fichier minimal (`remember()`, à la façon de `Cache::remember()` du module 08.2) sans dépendre de Laravel ni d'un serveur Redis.
- Simuler des réponses HTTP dans les tests avec `MockHandler` de Guzzle, garantissant des tests rapides et reproductibles, sans dépendre de la disponibilité du service externe.
- Gérer proprement les échecs réseau (timeout, réponse inattendue) avec des exceptions explicites.

## 📂 Structure du projet

```
projet-02-api-consommation-externe/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── composer.json
├── src/
│   ├── Cache/FileCache.php
│   └── MeteoClient.php
├── bin/meteo.php
└── tests/MeteoClientTest.php
```

## 🚀 Pour commencer

1. [INSTALLATION.md](INSTALLATION.md).
2. [EXECUTION.md](EXECUTION.md).
3. [JOURNAL.md](JOURNAL.md) — la démarche de construction.
4. [CODE.md](CODE.md) — le code source complet du projet, à consulter et copier à tout moment.

**Suite du parcours :** [Projet : Outil CLI avec Artisan](../projet-03-outil-ligne-de-commande-artisan/README.md)
