# Mini-project: Livewire Admin Dashboard

> **Status:** ✅ Available

## 🎯 Learning objective

Build a moderation back-office for the classifieds platform (levels 07-09): a reactive table with search/sort/filter/pagination, instant actions (activate/deactivate/delete), and a statistics widget that updates in real time — **without writing a single line of JavaScript**, and with no separate API.

## 📋 Modules used

- [10.1 — Livewire: The Fundamentals](../01-livewire-fondamentaux/README.en.md)
- [10.2 — Reactive Components and Forms](../02-composants-reactifs-formulaires/README.en.md) (event-based communication between `AnnoncesTable` and `StatistiquesWidget`)
- [10.3 — Alpine.js](../03-alpine-js-interactivite/README.en.md) (delete confirmation, purely client-side)
- [10.4 — Dynamic Tables](../04-tables-dynamiques-tri-filtre-recherche/README.en.md) (debounced search, sort, filter, `#[Url]`, pagination)

## 🧠 What you'll learn

- Make two independent Livewire components communicate (`AnnoncesTable` → event → `StatistiquesWidget`) without either one directly knowing the other exists.
- Combine Alpine.js (instant confirmation, no server request) and Livewire (the real action, with a server request) on the same button.
- Reuse the `Annonce` model and its scopes (`actives()`, `deLaCategorie()`) from level 07/08 with no modification, once again.
- Test Livewire components with Pest (`Livewire::test()`), including their interactions (`set()`, `call()`, `assertSee()`).

## 📂 Project structure

Files to add on top of the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md):

```
projet-mini-07-dashboard-admin-livewire/
├── README.md / INSTALLATION.md / EXECUTION.md / JOURNAL.md / RESSOURCES.md
├── database/migrations/    # adds users.est_admin
├── app/Livewire/Admin/
│   ├── AnnoncesTable.php        # search, sort, filter, pagination, actions
│   └── StatistiquesWidget.php     # listens for changes, recalculates
├── resources/views/
│   ├── admin/dashboard.blade.php
│   └── livewire/admin/
│       ├── annonces-table.blade.php
│       └── statistiques-widget.blade.php
├── routes/web.php
└── tests/Feature/AnnoncesTableTest.php
```

## 🚀 Getting started

1. [INSTALLATION.md](INSTALLATION.en.md) — install Livewire, copy these files, create an admin account.
2. [EXECUTION.md](EXECUTION.en.md) — use the dashboard, observe reactivity with no page reload.
3. **Before reading the provided code**, try building the event-based communication between the two components yourself, based on module 10.2.
4. [JOURNAL.md](JOURNAL.en.md) — the full build process.

**Next in the path:** [Level 11 — Advanced DevOps](../../11-devops-docker-cicd-avance/README.en.md)
