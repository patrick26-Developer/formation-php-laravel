# 00.1 — Path Overview

> **Status:** ✅ Available

## 🎯 Objectives

- Understand the philosophy and structure of the training.
- Know how to navigate between levels, modules, and projects.
- Understand what is expected of you at each step.

## 📋 Prerequisites

None. This is the very first module.

## ⏱️ Estimated duration

15 minutes of reading.

## 📖 Why this training exists

There are hundreds of PHP and Laravel tutorials on the internet, but few paths that go **from the first `echo "Hello World";` all the way to building a multi-tenant SaaS with an API, tests, and a CI/CD pipeline**, while keeping the same pedagogical consistency throughout. That is the goal of this repository: to be a single, free, and sufficiently complete reference so you never need to look elsewhere for the fundamentals.

## 📖 The 15-level structure

The training is split into levels numbered `00` to `14`. They are designed to be followed **in order** the first time through:

1. **00 — Introduction** *(you are here)*: setup.
2. **01 to 03 — PHP**: from the fundamentals (variables, loops, functions) to advanced PHP (OOP, design patterns, a homemade mini-framework, native API). You first build your own understanding of the language **without a framework**, so you never depend on Laravel's "magic" without knowing what's underneath.
3. **04 and 05 — Cross-cutting**: in-depth databases and professional tools (advanced Git, Docker, CI/CD, code quality). These skills will serve the rest of the path.
4. **06 to 10 — Laravel**: from beginner Laravel to building complete REST APIs and fullstack applications with Livewire.
5. **11 — Advanced DevOps**: dockerizing and deploying a real Laravel application, with a complete CI/CD pipeline.
6. **12 and 13 — Projects**: projects without a database (to diversify skills) and complete "portfolio" large projects.
7. **14 — Professional preparation**: architecture, code review, technical interviews, technology watch.

## 📖 How a module is built

Every lesson module (in levels 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 14) contains:

- A **`README.md`**: the lesson itself — objectives, theory, commented code examples, key takeaways.
- An **`EXERCICES.md`**: exercises to do yourself, from easiest to hardest.
- A **`solutions/`** folder: commented answer keys — to consult **after** trying, never before.

## 📖 How a project (mini or large) is built

Levels 01, 02, 03, 06, 07, 08, 09, 10, 12, and 13 contain **hands-on projects**. A project is not a simple exercise: it's a small, complete application meant to run on your machine. Each project therefore contains a **documentation kit** of 5 files, each with a precise role:

| File | Answers the question... |
|---|---|
| `README.md` | *"Why does this project exist and what does it do?"* |
| `INSTALLATION.md` | *"How do I get this running on my machine?"* |
| `EXECUTION.md` | *"How do I launch and use it day to day?"* |
| `JOURNAL.md` | *"How was it built, step by step?"* |
| `RESSOURCES.md` | *"Where do I find more information if I want to go deeper?"* |

This separation is deliberate: when you're looking for "how do I install the dependencies," you don't want to scroll through the project's pedagogical introduction. Each file gets straight to the point.

## ✅ Key takeaways

- The training is followed **in order**, level by level.
- A module = lesson + exercises + solutions.
- A project = complete application + 5-file documentation kit.
- The [SOMMAIRE.en.md](../../SOMMAIRE.en.md) at the root is your map: always come back to it if you're lost.

## ➡️ Going further

- [SOMMAIRE.en.md](../../SOMMAIRE.en.md) — the complete table of contents
- [CONTRIBUTING.md](../../CONTRIBUTING.md) — if you want to contribute to the training

---

**Next:** [00.2 — Environment Setup](../02-installation-environnement/README.en.md)
