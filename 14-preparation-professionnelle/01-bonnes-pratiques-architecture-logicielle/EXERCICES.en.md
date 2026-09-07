# Exercises — 14.1 Software Architecture Best Practices

## Exercise 1 — Identify the principle (easy)

For each of these excerpts from the training, name the SOLID/architectural principle it illustrates: (a) `AnnoncePolicy` centralizing authorization rules, (b) `RapportGenerator::lireCsv()`/`construireHtml()`/`convertirEnPdf()` kept separate, (c) `Cache::remember()` avoiding recomputing an expensive piece of data.

## Exercise 2 — Diagnosing a signal (easy)

An `InvoiceController::genererPdf()` controller is 180 lines long: direct SQL queries, date formatting, a call to Dompdf, sending an email. Identify at least 3 mixed responsibilities and propose a breakdown (what classes/services would you create?).

## Exercise 3 — Avoiding over-engineering (medium)

A junior developer proposes introducing a Repository, a `ProduitRepositoryInterface` interface, and a Factory pattern for a simple 3-field CRUD (name, price, stock) with no particular business logic. Write, in 5-6 sentences, the argument you'd give them to encourage simplifying — without discouraging them.

## Exercise 4 — Arguing an architectural choice (medium)

Revisit `BillingService`'s transactional decision (large project 13.4): a payment failure leaves the invoice "unpaid" rather than cancelling everything. Write a short paragraph (as if presenting it in an interview) explaining THIS choice, WHY it differs from the e-commerce checkout flow, and WHAT risk not doing so would create.

## Exercise 5 — Designing a justified evolution (hard)

The [Classifieds Platform mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md) is growing: 200,000 listings, 50 categories, a team of 6 developers. Identify, among the lesson's signals, which would justify an architecture evolution for THIS specific project, and which would NOT justify one yet. Propose a 3-step evolution plan, prioritized by impact/risk.

---

*(Since this module is reflective, there are no fixed "solutions" to compare against — but an indicative answer key is provided to guide your thinking.)*

See [solutions/README.md](solutions/README.md).
