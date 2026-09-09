# Indicative Answer Key — 14.3 Technical Interview Preparation

## Exercise 1

*"How do you avoid the N+1 problem?"* — "I use eager loading with `with()`. Concretely, in my blog mini-project (module 06), without `Article::with('categorie')`, displaying 20 articles with their category triggered 21 SQL queries instead of 2 — verifiable with `DB::listen()`. I systematically apply `whenLoaded()` in my API Resources to avoid the same mistake on the API side (module 09.2)."

## Exercise 2

**Situation**: In my multi-user SaaS mini-project (level 08), I needed to guarantee data isolation between tenants. **Task**: make sure no query could accidentally expose another tenant's data. **Action**: I implemented an Eloquent global scope on the `Project` model, then wrote a dedicated test suite (`IsolationTenantTest`) explicitly verifying that a tenant A user can neither list nor view tenant B's projects. **Result**: the tests revealed that a raw Query Builder query (`DB::table()`) bypassed the scope — a discovery that directly led to a documented coding rule for the whole team.

## Exercise 3

*(Example script for the E-commerce large project)*: "I built a minimal e-commerce site to dig deeper into transactional database management [Problem]. The most interesting decision concerns the checkout flow: all the logic — order creation, stock decrement, payment call — is encapsulated in a single Laravel transaction, guaranteeing no inconsistent state is ever persisted on failure [Technical choice]. The main difficulty was clearly distinguishing this case from a neighboring project (my billing SaaS), where a payment failure must, ON THE CONTRARY, leave a record rather than cancel everything — it taught me that the same technical mechanism can hide two opposite business decisions [Difficulty]. Given more time, I'd add a real Stripe integration to replace my simulated gateway [Critical hindsight]."

## Exercise 4

```php
function motsLesPlusFrequents(string $texte, int $n): array
{
    $mots = str_word_count(strtolower($texte), 1);
    $frequences = array_count_values($mots);
    arsort($frequences);

    return array_slice($frequences, 0, $n, true);
}
```
`array_count_values()` is well suited here: it counts in O(n) over the
number of words, in a single pass. `arsort()` then sorts in O(m log m)
over the number of DISTINCT words (generally much smaller than the
total text). Overall complexity is dominated by the sort: O(m log m).

## Exercise 5

Clarifying questions: (1) Which channels are needed (email, push, SMS,
in-app)? (2) Must notifications be real-time, or is a delay of a few
seconds acceptable? (3) What's the expected peak of notifications per
second? (4) Is a browsable history needed, and for how long? (5) Are
there user preferences (per-channel opt-out) to respect?

Answer sketch: each notification would be dispatched via a Queue
(module 08.1) rather than processed synchronously, with several
horizontally scalable workers to absorb the peak. The `database`
channel (module 07.7) would feed a browsable notification center, with
a cache (module 08.2) on the unread-notification count to avoid a
counting query on every page load. Rate limiting (module 09.6) would
protect against abusive sending to the same user in case of a bug in
an emitting service.
