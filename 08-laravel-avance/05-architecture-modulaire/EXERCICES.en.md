# Exercises — 08.5 Modular Architecture and Multi-tenancy

## Exercise 1 — Identifying a need for reorganization (easy)

List, for the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md), every file related to the "Annonce" domain (model, controller, policy, requests, notification). Does this project genuinely need a domain-driven reorganization? Justify your answer.

## Exercise 2 — tenant_id column (easy)

Add a `tenant_id` column to a simulated `projets` table. Create two tenants and projects for each.

## Exercise 3 — Global tenant scope (medium)

Implement the lesson's global scope on the `Projet` model. Verify that `Projet::all()` only returns the logged-in user's tenant's projects (simulate login via Tinker with `Auth::login()`).

## Exercise 4 — Demonstrating the bypass flaw (medium)

Show that a `DB::table('projets')->get()` query (raw Query Builder, no Eloquent) correctly bypasses the global scope — displaying projects from ALL tenants. Explain in a comment why this discovery justifies a strict team rule ("always go through the Eloquent model, never `DB::` directly for tenant-isolated tables").

## Exercise 5 — Comparing the three strategies (hard)

Write a short comparison (`STRATEGIE.md`) arguing, for a fictional case (a SaaS platform for managing medical practices, sensitive data), which multi-tenancy strategy to choose among the lesson's three, weighing the security/complexity/infrastructure-cost trade-off.

---

See [solutions/README.md](solutions/README.md) for the answer key.
