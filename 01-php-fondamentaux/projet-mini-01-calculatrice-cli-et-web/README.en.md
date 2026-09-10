# Mini-project: CLI and Web Calculator

> **Status:** ✅ Available

## 🎯 Learning objective

Apply Level 01's concepts together (typed functions, `match`, exception-based error handling, HTML forms, command-line arguments) by building **a single calculation logic reused by two different interfaces**: one on the command line (CLI) and one in a browser (Web).

## 📋 Modules used

- [01.2 — Operators and Control Structures](../02-operateurs-structures-controle/README.en.md) (`match`)
- [01.4 — Functions and Variable Scope](../04-fonctions/README.en.md) (typed functions)
- [01.7 — HTML Forms and GET/POST](../07-formulaires-http-get-post/README.en.md)
- [01.9 — Introduction to Error Handling](../09-gestion-erreurs-debutant/README.en.md) (exceptions)

## 🧠 What you'll learn

- Separating **business logic** (the calculation) from its **interfaces** (CLI, Web) to avoid duplicating code — a principle that will resurface at every level of this training, all the way to MVC architecture (level 03) and Laravel.
- Reading arguments passed on the command line (`$argv`).
- Cleanly handling a business error (division by zero) with exceptions, across two different display contexts (terminal, HTML).

## 📂 Project structure

```
projet-mini-01-calculatrice-cli-et-web/
├── README.md          # this file
├── INSTALLATION.md      # how to set up the project
├── EXECUTION.md          # how to run and use it
├── JOURNAL.md             # how it was built, step by step
├── RESSOURCES.md           # useful links
└── src/
    ├── Calculatrice.php    # shared calculation logic (calculate/divide functions)
    ├── cli.php               # command-line entry point
    └── web/
        └── index.php          # web entry point (HTML form)
```

## 🚀 Getting started

1. Read [INSTALLATION.md](INSTALLATION.en.md) to set up the project (no external dependency here, just PHP).
2. Read [EXECUTION.md](EXECUTION.en.md) to launch both interfaces.
3. **Before reading the provided code**, try recoding `src/Calculatrice.php` yourself from the level 01 modules.
4. Check [JOURNAL.md](JOURNAL.en.md) to see how this project was built in order, and compare it with your own approach.
5. [CODE.md](CODE.en.md) — the project's complete source code, to browse and copy at any time.

**Next in the path:** [Level 02 — Intermediate PHP](../../02-php-intermediaire/README.en.md)
