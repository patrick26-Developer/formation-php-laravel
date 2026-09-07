# 🐘 PHP → Laravel — The Complete Training

> From zero to expert: modern PHP, Laravel, databases, REST APIs, fullstack, Docker and CI/CD — free, for everyone.

🇫🇷 [Français](README.md) (source language, always the most up to date) · **🇬🇧 English** *(translation in progress, level by level)*

---

## 🎯 Who is this for?

This repository is a **complete, free, and progressive** training program to learn PHP from absolute basics up to expert mastery of **Laravel**, the most widely used PHP framework in the world. It is aimed at:

- **Complete beginners** in programming who want a structured, gap-free path.
- Developers from other languages who want to become productive in PHP/Laravel quickly.
- Intermediate PHP developers who want to fill gaps (security, testing, architecture, DevOps).
- Developers preparing for technical interviews or wanting to industrialize their practices (Docker, CI/CD).

## 🗺️ How to navigate

The pedagogical entry point is **[SOMMAIRE.en.md](SOMMAIRE.en.md)**: the complete table of contents of the training, level by level, with the progress status of each module (✅ available, 🚧 in progress, 📋 planned).

The training is organized into **15 numbered levels** (`00-introduction` → `14-preparation-professionnelle`), meant to be followed in order the first time. Each level is a folder containing numbered **modules**, and each module contains:

- `README.md` / `README.en.md` — the lesson itself (theory + commented code examples)
- `EXERCICES.md` — exercises to practice *(currently French only, see note below)*
- `solutions/` — commented answer keys *(currently French only)*
- optionally, runnable code (`code/`)

**Mini-projects** and **large projects** are separate folders, attached to the level that makes them possible. Each one contains a **standard documentation kit** — see [CONTRIBUTING.md](CONTRIBUTING.md#kit-documentaire-dun-projet) for the role of each file (installation, execution, build journal, resources).

> 📌 **Translation scope note:** the English translation currently covers each module's lesson (`README.en.md`) and each project's full documentation kit (`README.en.md`, `INSTALLATION.en.md`, `EXECUTION.en.md`, `JOURNAL.en.md`, `RESSOURCES.en.md`). Exercise statements and answer keys remain French-only for now — the folder names themselves (`00-introduction`, `01-php-fondamentaux`...) also stay in French to keep a single, stable link structure between both languages.

## 🧭 Level overview

| Level | Theme | Tier |
|---|---|---|
| [00](00-introduction/) | Introduction & setup | Prerequisite |
| [01](01-php-fondamentaux/) | PHP Fundamentals | Beginner |
| [02](02-php-intermediaire/) | Intermediate PHP (OOP, security, PDO) | Beginner → Intermediate |
| [03](03-php-avance/) | Advanced PHP (patterns, homemade MVC, tests, API) | Intermediate → Advanced |
| [04](04-bases-de-donnees-approfondi/) | Databases in depth | Cross-cutting |
| [05](05-outils-professionnels/) | Pro tools (Git, Docker, CI/CD, quality) | Cross-cutting |
| [06](06-laravel-fondamentaux/) | Laravel Fundamentals | Laravel Beginner |
| [07](07-laravel-intermediaire/) | Intermediate Laravel | Intermediate |
| [08](08-laravel-avance/) | Advanced Laravel | Advanced |
| [09](09-api-rest-laravel/) | REST API with Laravel | Expert Backend |
| [10](10-fullstack-laravel-livewire/) | Fullstack with Livewire | Expert Fullstack |
| [11](11-devops-docker-cicd-avance/) | DevOps: Advanced Docker & CI/CD | Expert |
| [12](12-projets-sans-base-de-donnees/) | Projects without a database | Cross-cutting practice |
| [13](13-grands-projets/) | Complete minimal large projects | Portfolio |
| [14](14-preparation-professionnelle/) | Professional preparation | Career |

Full details, objectives, and associated projects: **[see the SOMMAIRE](SOMMAIRE.en.md)**.

## 🚀 Where to start

1. Read [00-introduction/01-presentation-parcours](00-introduction/01-presentation-parcours/README.en.md) to understand the philosophy of the path.
2. Set up your environment with [00-introduction/02-installation-environnement](00-introduction/02-installation-environnement/README.en.md).
3. Follow the levels in order, do **all the exercises**, build **all the mini-projects**.
4. Check [ressources/](ressources/) at any time for cheatsheets and the FAQ.

## 🛠️ Training reference stack

- **PHP** 8.3+ (modern syntax: strict types, enums, readonly, match...)
- **Laravel** (latest stable version)
- **Fullstack**: Blade + **Livewire** (100% PHP, no heavy JS framework)
- **Database**: MySQL / MariaDB
- **Testing**: PHPUnit (foundations) then **Pest** (Laravel)
- **DevOps**: Docker, Docker Compose, GitHub Actions

## 📜 License

This project is under the [MIT](LICENSE) license — free to use, copy, modify, and redistribute, including commercially, provided the copyright notice is kept.

## 🤝 Contributing

This training is meant to become a community reference. See [CONTRIBUTING.md](CONTRIBUTING.md) for content conventions, the project documentation kit, and how to propose an improvement.

## 📓 Project tracking

- [CHANGELOG.md](CHANGELOG.md) — log of the training's own evolution.
- [ROADMAP.md](ROADMAP.md) — what's done, in progress, and upcoming.
