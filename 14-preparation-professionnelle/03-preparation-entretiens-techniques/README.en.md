# 14.3 — Technical Interview Preparation

> **Status:** ✅ Available

## 🎯 Objectives

- Know the most common PHP/Laravel technical interview formats.
- Prepare structured answers to classic questions.
- Practice typical algorithm exercises, with no framework dependency.
- Know how to present a portfolio project (the level 13 large projects) convincingly.

## 📋 Prerequisites

All of levels 00 through 13.

## ⏱️ Estimated duration

3h, spread across several practice sessions.

## 📖 Theory

### Common technical interview formats

| Format | What to expect | How to prepare |
|---|---|---|
| **Knowledge questions** | "What's the difference between `bind` and `singleton`?" (module 08.4) | Reread this training's "Key takeaways" sections |
| **Live coding exercise** | Solve a small algorithmic problem on a whiteboard/shared screen | Practice speaking out loud, explaining your reasoning as you code |
| **Code review** | Critique a provided code snippet | Reuse the checklist from [module 14.2](../02-code-review-et-refactoring/README.en.md) |
| **Project presentation** | Present a personal (portfolio) project | Prepare a 3-5 minute presentation for each level 13 large project |
| **System design / architecture** | "How would you design a system for X?" | Practice asking clarifying questions BEFORE proposing a solution |

### Classic knowledge questions, with a pointer to the matching module

- *"Explain a Laravel request's lifecycle."* → [module 06.1](../../06-laravel-fondamentaux/01-installation-configuration-artisan/README.en.md) (routing), [module 07.3](../../07-laravel-intermediaire/03-middlewares-form-requests/README.en.md) (middlewares).
- *"How do you avoid the N+1 problem?"* → [module 07.1](../../07-laravel-intermediaire/01-eloquent-relations-avancees/README.en.md) (`with()`, `whenLoaded()`).
- *"Difference between authentication and authorization?"* → [module 07.5](../../07-laravel-intermediaire/05-autorisations-policies-gates/README.en.md).
- *"How do you protect against SQL injection?"* → [module 02.6](../../02-php-intermediaire/06-securite-web-fondamentaux/README.en.md) (prepared statements).
- *"What's a transaction and when do you use one?"* → [module 04.2](../../04-bases-de-donnees-approfondi/02-sql-avance-jointures-index-transactions/README.en.md), illustrated in the [e-commerce large project](../../13-grands-projets/grand-projet-02-ecommerce-minimal/README.en.md).
- *"How do you test a queue without actually running it?"* → [module 08.3](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.en.md) (`Queue::fake()`).

> 💡 A good answer never recites a memorized definition — it **illustrates with a concrete example**, ideally drawn from a project you actually built. "I ran into this exact problem in my SaaS project, where..." is always more convincing than "In theory, you should...".

### The STAR method for behavioral questions

A technical interview often includes non-technical questions ("Tell me about a difficult bug you solved"). The **STAR** method structures an answer:

- **S**ituation: the context (which project, what problem).
- **T**ask: what was expected of you.
- **A**ction: what you concretely did.
- **R**esult: the outcome, ideally measurable.

> 📌 A concrete, reusable example from this training: *"In my multi-tenant SaaS project (Situation), I needed to guarantee that no data could leak between organizations (Task). I implemented an Eloquent global scope backed by a test suite dedicated to isolation (Action). The tests revealed that a raw Query Builder query bypassed the scope — I documented this limitation and established a team rule (Result)."* — directly inspired by [module 08.5](../../08-laravel-avance/05-architecture-modulaire/README.en.md).

### Presenting a portfolio project in 3-5 minutes

1. **The problem** (30s): what need does this project solve?
2. **Key technical choices** (2 min): 2-3 interesting architecture decisions, NOT an exhaustive list of technologies used.
3. **A difficulty encountered and how it was resolved** (1 min): shows the ability to reason, not just follow a tutorial.
4. **What you would do differently** (30s): shows critical hindsight, a highly valued quality.

> 💡 Each level 13 large project's `JOURNAL.md` is **directly reusable** as preparation material for this exercise: every step already explains the "why" behind a decision — exactly the raw material for a good portfolio presentation.

## ✅ Key takeaways

- Illustrating a theoretical answer with a concrete, lived example is always more convincing than a recited definition.
- The STAR method structures a behavioral answer clearly and completely.
- A project presentation should highlight decisions and difficulties, not a list of technologies.
- This training's `JOURNAL.md` files are direct preparation for the technical interview.

## ➡️ Going further

- [github.com/kdn251/interviews](https://github.com/kdn251/interviews) (data structures and algorithms, general-purpose)
- Reread the complete [SOMMAIRE.md](../../SOMMAIRE.en.md) to identify which modules to prioritize reviewing based on your perceived weak spots.

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [14.2 — Code Review and Refactoring](../02-code-review-et-refactoring/README.en.md) · **Next:** [14.4 — Technology Watch and the PHP/Laravel Ecosystem](../04-veille-et-ecosysteme-php-laravel/README.en.md)
