# 14.2 — Code Review and Refactoring

> **Status:** ✅ Available

## 🎯 Objectives

- Review code with a methodical checklist rather than an impressionistic pass.
- Phrase a review comment that's constructive and actionable.
- Refactor existing code without breaking its behavior.
- Use tests as a safety net during a refactor.

## 📋 Prerequisites

[14.1 — Software Architecture Best Practices](../01-bonnes-pratiques-architecture-logicielle/README.en.md), [08.3 — Pest and PHPUnit Tests](../../08-laravel-avance/03-tests-pest-phpunit-laravel/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### A checklist for a code review

Reviewing code at random, line by line, with no method, leads to uneven reviews (sometimes too superficial, sometimes obsessed with unimportant style details). A layered checklist helps stay systematic:

1. **Correctness**: does the code do what it claims to? Does it handle edge cases (modules 02.4, 01.9)?
2. **Security**: input validation (module 02.6), authorization (module 07.5), no sensitive data logged (module 11.5)?
3. **Readability**: can a developer discovering this code understand it without having to ask its author?
4. **Consistency**: does it follow the conventions already established in the project (module 03.5)?
5. **Performance**: an N+1 problem (module 03.6/07.1)? A query inside a loop?
6. **Tests**: is the new/changed behavior covered (module 08.3)?

> 📌 This order is deliberate: correctness and security always outrank style. A comment like "missing a semicolon" on a PR that contains an authorization flaw is a review that missed the point.

### Phrasing a constructive comment

```markdown
❌ "This code is badly written."
❌ "Why don't you use a Service here?"

✅ "This `store()` method is 45 lines long and mixes validation, business
   logic, and sending an email. I'd suggest extracting the email send into
   a Job (module 08.1): it would decouple the HTTP response from the
   email actually going out, and it would be easier to test with
   Queue::fake()."

✅ "Question: what happens if $request->user()->tenant is null here
   (a user with no assigned tenant)? I don't see a guard against this
   case — a TypeError seems possible as it stands."
```

> 💡 A good review comment: (1) describes an observable fact, not a judgment of the person; (2) explains the **why** behind the problem (real impact); (3) suggests a concrete direction, without necessarily imposing it as the only valid solution. Asking a question ("what happens if...") is often more effective than a statement, especially when you aren't 100% sure there's a real problem.

### Refactoring safely: tests first

```
1. A failing test must first FAIL for the right reason
   (if you're fixing a bug: write the test BEFORE the fix,
   verify it fails, THEN fix it).
2. A refactor (changing structure WITHOUT changing behavior)
   must start from an already GREEN test suite.
3. At every step of the refactor, rerun the tests.
4. NEVER mix refactoring and a behavior change in the same
   commit — it makes it impossible to identify which change
   introduced a regression if a test breaks.
```

> ⚠️ Refactoring code **with no test safety net** is a risky bet: there's no way to know for certain whether behavior was preserved. On legacy code with no tests, the first step of a serious refactor is often to **write characterization tests** (which document CURRENT behavior, even if imperfect) before touching the code.

### An example of a test-driven refactor

```php
// BEFORE: duplicated logic, hard to test in isolation
public function index(Request $request)
{
    $annonces = Annonce::where('active', true);
    if ($request->recherche) {
        $annonces = $annonces->where('titre', 'like', '%' . $request->recherche . '%');
    }
    // ... 15 more lines of similar filters ...
    return view('annonces.index', ['annonces' => $annonces->paginate(10)]);
}
```

```php
// AFTER: extracting a scope (module 07.2), testable independently
// of the controller, with no simulated HTTP request needed
public function scopeFiltrees($query, array $filtres)
{
    return $query
        ->when($filtres['recherche'] ?? null, fn ($q, $v) => $q->where('titre', 'like', "%$v%"))
        ->when($filtres['categorie'] ?? null, fn ($q, $v) => $q->where('categorie_id', $v));
}

public function index(Request $request)
{
    $annonces = Annonce::actives()->filtrees($request->only(['recherche', 'categorie']))->paginate(10);
    return view('annonces.index', compact('annonces'));
}
```

## ✅ Key takeaways

- A checklist (correctness → security → readability → consistency → performance → tests) avoids uneven reviews.
- A constructive review comment describes a fact, explains the impact, suggests a direction — without judging the person.
- Refactoring requires a green test suite to start from; on untested code, write characterization tests first.
- Never mix refactoring and a behavior change in the same commit.

## ➡️ Going further

- *Refactoring*, Martin Fowler
- [google.github.io/eng-practices/review](https://google.github.io/eng-practices/review/) (Google's public code review guide)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [14.1 — Software Architecture Best Practices](../01-bonnes-pratiques-architecture-logicielle/README.en.md) · **Next:** [14.3 — Technical Interview Preparation](../03-preparation-entretiens-techniques/README.en.md)
