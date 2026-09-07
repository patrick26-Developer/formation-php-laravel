# 14.1 — Software Architecture Best Practices

> **Status:** ✅ Available

## 🎯 Objectives

- Synthesize the architecture principles encountered throughout the training.
- Recognize the signals that justify an architecture evolution.
- Avoid the two symmetric excesses: over-engineering and uncontrolled technical debt.
- Argue for an architectural choice in front of a team or in an interview.

## 📋 Prerequisites

All of levels 00 through 13.

## ⏱️ Estimated duration

2h of reading and reflection.

## 📖 Theory

### What you've already learned, without always naming it

This training introduced architecture principles throughout the projects, without always presenting them as formal principles. This module names them and connects them:

| Principle | Where it was applied |
|---|---|
| **Single Responsibility (SRP)** | `RapportGenerator` (module 12.1): one class, one public method |
| **Dependency Inversion (DIP)** | `PaymentGateway` (large project 13): business code depends on an interface, not an implementation |
| **Open/Closed (OCP)** | Policies (module 07.5): adding an authorization rule doesn't require modifying the controller |
| **YAGNI** ("You Aren't Gonna Need It") | Module 08.5: never reorganize into a domain-driven architecture in anticipation |
| **DRY** ("Don't Repeat Yourself") | The shared Blade form `_form.blade.php` (module 06, mini-project) |
| **Separation of Concerns** | MVC (module 03.2), Controller/Service/Repository separation in the large projects |

### The signals that justify an architecture evolution

An architecture is never changed "because it's better in theory" — always in response to **concrete, observed pain**:

| Observed signal | Possible evolution |
|---|---|
| A controller exceeds 150-200 lines, mixing business logic and HTTP | Extract a Service (module 08.4) |
| The same complex `WHERE` query copy-pasted into 4 controllers | An Eloquent scope (module 07.2) |
| Impossible to test a class without a real database/API | Introduce an interface + dependency injection (module 08.4) |
| `app/Models/` and `app/Http/Controllers/` each hold 50+ files, painful navigation | Domain-driven architecture (module 08.5) — **only at this scale** |
| The same validation rule duplicated in 3 places | A shared Form Request (module 06.6), or a custom validation rule |

> ⚠️ **Over-engineering is a trap just as real as technical debt.** A junior developer anxious about looking "not professional enough" sometimes introduces Repositories, interfaces, and Design Patterns onto a 3-field CRUD that needs none of it — adding complexity with no benefit, purely to "look serious." The right question is never "is this pattern elegant?" but "what concrete problem does this pattern solve, here, now?"

### An example of complete architectural reasoning

Revisit the [billing SaaS large project](../../13-grands-projets/grand-projet-04-saas-facturation/README.en.md): why does `PlanLimitService` exist as a separate class, rather than a method on the `Tenant` model or a check directly in the controller?

- **Rejected alternative 1**: a check in the controller → duplicated as soon as a second plan-limited resource appears (users, storage).
- **Rejected alternative 2**: a method on `Tenant` → mixes the "represent a tenant" responsibility (an Eloquent model's role) with "enforce a billing business rule" — two different responsibilities.
- **Chosen approach**: a dedicated Service, injectable, independently testable (as `LimitePlanTest` proves), which becomes the natural extension point for any future plan rule.

> 💡 **This kind of reasoning — comparing alternatives, identifying the trade-off, justifying the chosen approach — is what distinguishes a senior developer from one who applies patterns without understanding them.** In a technical interview (module 14.3), this ability to argue a case is often valued more than the solution itself.

## ✅ Key takeaways

- Every architecture principle in this module has already been concretely applied in a training project — revisit those projects if a principle still feels abstract.
- An architecture evolution always responds to observed pain, never a trend or anticipation.
- Over-engineering (unjustified complexity) is a trap just as real as technical debt (poorly managed complexity).
- Knowing how to compare alternatives and justify an architectural choice is a senior skill in its own right.

## ➡️ Going further

- *Clean Architecture*, Robert C. Martin
- *A Philosophy of Software Design*, John Ousterhout (on "shallow" vs. "deep" complexity)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [Level 13 — Large Projects](../../13-grands-projets/README.en.md) · **Next:** [14.2 — Code Review and Refactoring](../02-code-review-et-refactoring/README.en.md)
