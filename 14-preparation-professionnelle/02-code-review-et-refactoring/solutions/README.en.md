# Indicative Answer Key — 14.2 Code Review and Refactoring

## Exercise 1

- **Correctness**: `Article::find($id)` can return `null` — a subsequent call to `$article->titre` would cause a fatal error if the ID doesn't exist.
- **Security**: no input validation (`$request->titre` could be empty, or exceed the column's size); no authorization check (any logged-in user can edit any article).
- **Readability**: fine for such a small controller, nothing notable.
- **Consistency**: `Article::find($id)` rather than Model Binding (`Article $article` as a parameter), which would have automatically handled the "not found" case (404) — inconsistent with the rest of the training since module 06.2.
- **Performance**: not applicable here.
- **Tests**: no visible test for this method.

## Exercise 2

- "This method is nonsense" → "This method handles validation, calls to three external services, and building the response all at once — I'd suggest splitting it by extracting at least the external call into a dedicated class, which would make testing and reading easier."
- "Use a Form Request." → "This inline validation is duplicated in `store()` and `update()` (same rules) — a shared Form Request (module 06.6) would avoid this duplication and centralize any future rule change."

## Exercise 3

```php
test('trouverParUtilisateur returns only this user\'s tasks, sorted by descending date', function () {
    // Documents the CURRENT behavior before any refactoring
    $repo = new TacheRepository($pdo);
    $resultat = $repo->trouverParUtilisateur(1);
    expect($resultat)->toBeArray();
    // ... assertions on the observed order and filtering ...
});
```
Once this test is green, the internal SQL query can be rewritten (for
example, simplifying a condition concatenation) as long as the test
stays green at every step — proof that the external behavior hasn't
changed, even though the implementation has been improved.

## Exercise 4

"This loop triggers one SQL query per order to load `$commande->user`
(the N+1 problem, module 03.6/07.1) — with 1000 orders, that's 1001
queries instead of 2. Suggestion: `Order::with('user')->get()` to load
the relationship in a single extra query, regardless of the number of orders."

## Exercise 5

An example of a complete review structure (to adapt to the chosen controller):
```markdown
## Review of AnnonceController

### Correctness
Nothing to flag — edge cases (listing not found, insufficient stock if
applicable) seem handled via Model Binding and Form Requests.

### Security
Verified: every edit action goes through `$this->authorize()` or a
Policy — consistent with module 07.5. Nothing to flag.

### Readability
`index()` stays readable despite combining search/filter/sort/pagination
thanks to `when()` (module 06.7) rather than a chain of `if`s.

### Consistency
Nothing to flag — follows the rest of the project's standard Laravel conventions.

### Performance
Verified: `with(['categorie', 'user'])` present on `index()`, avoids the N+1.

### Tests
Missing: no test covers the "search + category filter combined
simultaneously" case — suggest adding this case to the existing suite.
```
