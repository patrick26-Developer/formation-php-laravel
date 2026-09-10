# Project: Consuming an External API

> **Status:** ✅ Available

## 🎯 Learning objective

Consume a third-party HTTP API (weather, no key required) with a **local file cache** — no database — and test the HTTP client without ever making a real network call during tests.

## 📋 Modules used

- [02.7 — Composer, Autoloading, PSR](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md) (the `guzzlehttp/guzzle` dependency)
- [08.2 — Cache and Performance Optimization](../../08-laravel-avance/02-cache-optimisation-performance/README.en.md) (the caching principle, here without Laravel)
- [03.3 — Unit Testing with PHPUnit](../../03-php-avance/03-tests-unitaires-phpunit/README.en.md) (mocking an HTTP client)
- [02.4 — Exception Handling](../../02-php-intermediaire/04-gestion-exceptions/README.en.md)

## 🧠 What you'll learn

- Use Guzzle, the standard HTTP client of the PHP ecosystem, to query an external REST API.
- Implement a minimal file cache (`remember()`, in the style of `Cache::remember()` from module 08.2) with no dependency on Laravel or a Redis server.
- Simulate HTTP responses in tests with Guzzle's `MockHandler`, guaranteeing fast, reproducible tests that don't depend on the external service's availability.
- Cleanly handle network failures (timeout, unexpected response) with explicit exceptions.

## 📂 Project structure

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

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md).
2. [EXECUTION.md](EXECUTION.en.md).
3. [JOURNAL.md](JOURNAL.en.md) — the build process.
4. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Project: CLI Tool with Artisan](../projet-03-outil-ligne-de-commande-artisan/README.en.md)
