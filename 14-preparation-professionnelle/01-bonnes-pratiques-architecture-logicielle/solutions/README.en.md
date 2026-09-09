# Indicative Answer Key — 14.1 Software Architecture Best Practices

## Exercise 1

- (a) Single Responsibility / Open-Closed: the authorization rule is centralized, extensible with no change to callers.
- (b) Single Responsibility applied at the scale of a class's private methods.
- (c) Not strictly a SOLID principle, but an application of proportionate performance (not redoing expensive work already done recently).

## Exercise 2

Mixed responsibilities: data access (direct SQL queries), presentation (formatting), document generation (Dompdf), notification (email). Proposed breakdown: an `Invoice` (model/query via Eloquent rather than raw SQL), an `InvoicePdfGenerator` (generation), an `InvoiceMailer` or a Notification (sending) — the controller becomes a simple few-line orchestrator calling these three services.

## Exercise 3

"I understand the desire to do things properly, but let's look at what each added layer actually solves here: the Repository would protect against an ORM change — unlikely and not requested; the interface would allow mocking in tests — but Eloquent tests very well directly with `RefreshDatabase`; the Factory would create objects — but `Product::create()` is enough. Every layer has a cost (extra files, indirection to follow when reading the code) that must be justified by a real need. Let's keep this architecture for the day a genuine signal appears — duplicating the same check in 4 places, for example — and stay simple today."

## Exercise 4

"In the e-commerce checkout flow, a declined payment means the transaction simply never happened: it makes sense to cancel the order and restore the stock, as if nothing occurred. For a SaaS subscription, the situation is different: the service has already been rendered over the elapsed period, the customer's payment obligation exists independently of the charge attempt's success. Cancelling the invoice would erase this record, preventing any follow-up or collection action later. The risk of not doing this: a customer whose card expired would keep using the service indefinitely with no invoice ever existing to document the unpaid amount."

## Exercise 5

Signals PRESENT that justify an evolution:
- 6 developers on the same code → risk of frequent conflicts on the same files if everything stays flat in `app/Http/Controllers/`.
- 200,000 listings → potential need for query optimization (module 04.3, indexes, cursor-based pagination rather than offset).

Signals ABSENT that do NOT yet justify a full domain-driven architecture:
- 50 categories alone doesn't create an unmanageable number of files.
- Nothing indicates a need to change database or ORM (no reason to introduce an abstract Repository).

3-step plan, by impact/risk:
1. (High impact, low risk) Audit and add missing indexes (module 04.3) on frequently searched/sorted columns.
2. (Medium impact, low risk) Switch large lists to cursor-based pagination if slowness is measured past around page 50.
3. (High impact, higher risk — trigger ONLY if navigation genuinely becomes painful) Progressively reorganize by domain (module 08.5), one domain at a time, never as a big bang.
