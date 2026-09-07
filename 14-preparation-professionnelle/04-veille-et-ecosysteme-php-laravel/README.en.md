# 14.4 — Technology Watch and the PHP/Laravel Ecosystem

> **Status:** ✅ Available

## 🎯 Objectives

- Know reliable sources for staying current on PHP and Laravel.
- Understand PHP's and Laravel's version release cycle.
- Know how to evaluate a new package before adopting it in a project.
- Situate this training within the broader ecosystem, to know where to go next.

## 📋 Prerequisites

None — a closing module, to revisit at any point in your career.

## ⏱️ Estimated duration

1h.

## 📖 Theory

### The version cycle: knowing what's stable, what's coming

- **PHP** releases a new major/minor version **every year, in November**; each version gets about 2 years of active support then 1 year of security-only fixes. This training uses PHP 8.3+ — always check the [official supported versions page](https://www.php.net/supported-versions.php) before starting a new project.
- **Laravel** releases a new major version **every year, generally in the first quarter**, with a similar support cycle. The structural changes encountered in this training (`bootstrap/app.php` replacing `Kernel.php` since Laravel 11, module 06.1) illustrate this pace of evolution — a good reason to always check the official documentation **for the version you're actually using**, not a memorized one.

### Reliable sources to follow

| Source | What it offers |
|---|---|
| [laravel-news.com](https://laravel-news.com/) | Laravel news, new packages, tutorials |
| [Laravel Daily (YouTube)](https://www.youtube.com/@LaravelDaily) | Regular practical tutorials |
| Official *release notes* ([laravel.com/docs/releases](https://laravel.com/docs/releases)) | The most reliable source for exact changes between versions |
| [PHP RFC (wiki.php.net/rfc)](https://wiki.php.net/rfc) | Track PHP language changes ahead of their release |
| Maintainers' Twitter/X and Bluesky (Taylor Otwell, Nuno Maduro...) | Real-time announcements, design discussions |
| [packagist.org](https://packagist.org/) | Discover and check a Composer package's popularity/maintenance |

> 📌 **A simple rule for filtering out noise**: always prefer official documentation and release notes over a third-party blog post, especially for code you're going to actually run — an undated article may document behavior that's been obsolete for several versions.

### Evaluating a package before adopting it

Before adding a Composer dependency to a project (a reminder from [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.en.md)), a few quick checks on its GitHub/Packagist page:

- **Last update date**: a package unmaintained for 2+ years is a risk, especially for security.
- **Number of installs** (Packagist) and stars (GitHub): an (imperfect) indicator of adoption, and thus of "real-world testing" by the community.
- **Open issues**: a backlog of unaddressed issues signals flagging maintenance.
- **Version compatibility**: does the package's `composer.json` explicitly declare support for your PHP/Laravel version?
- **Transitive dependencies**: how many additional packages does this package pull in with it?

> ⚠️ Every dependency added is a **long-term commitment**: it needs to be maintained (security updates), and an abandoned dependency can one day block a Laravel/PHP version upgrade itself. The reflex "there's a package for that" never excuses skipping the evaluation of whether adding it is really the right trade-off against a few dozen lines of homemade code.

### Where to go after this training

This training covers a solid, complete foundation, but the PHP/Laravel ecosystem continues beyond it:

- **Inertia.js**: an alternative to Livewire (level 10) for a Vue/React SPA while keeping Laravel's server-side routing.
- **Laravel Octane**: run Laravel on a persistent application server (Swoole/RoadRunner) for significantly better performance than classic PHP-FPM.
- **Laravel Nova/Filament**: automatically generated admin back-offices, an alternative to the hand-built admin controllers from levels 06-08 of this training.
- **Open source contribution**: once comfortable, contributing to an existing Laravel package (even a simple documentation fix) is an excellent way to learn and get noticed.

## ✅ Key takeaways

- PHP and Laravel evolve on a predictable annual rhythm; always check the documentation for the version you're actually using.
- Prefer official sources (release notes, documentation) over undated blog posts.
- Evaluate a package before adoption: recent maintenance, community adoption, version compatibility.
- This training is a foundation, not a ceiling — Inertia, Octane, Filament, and open source contribution are natural next steps.

## ➡️ Going further

- [laravel.com/docs/releases](https://laravel.com/docs/releases)
- [inertiajs.com](https://inertiajs.com/) / [laravel.com/docs/octane](https://laravel.com/docs/octane) / [filamentphp.com](https://filamentphp.com/)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [14.3 — Technical Interview Preparation](../03-preparation-entretiens-techniques/README.en.md) · **Back to the** [Table of Contents](../../SOMMAIRE.en.md)

---

## 🎓 Congratulations

You've made it through all 15 levels of this training, from your very first `echo "Hello, PHP!";` (module 00.2) to a multi-tenant SaaS with Docker and CI/CD (the level 13 large project). This foundation is now yours — keep building, keep making mistakes, and keep starting over: that's exactly how this path was designed from [module 00.4](../../00-introduction/04-methodologie-apprentissage/README.en.md) onward.
