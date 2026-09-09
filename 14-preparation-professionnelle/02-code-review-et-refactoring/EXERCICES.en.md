# Exercises — 14.2 Code Review and Refactoring

## Exercise 1 — Applying the checklist (easy)

Review this code and classify your observations according to the lesson's 6 layers (correctness, security, readability, consistency, performance, tests):

```php
public function update(Request $request, $id)
{
    $article = Article::find($id);
    $article->titre = $request->titre;
    $article->contenu = $request->contenu;
    $article->save();
    return redirect('/articles');
}
```

## Exercise 2 — Rewording comments (easy)

Reword these two review comments to make them constructive, following the lesson: "This method is nonsense." / "Use a Form Request."

## Exercise 3 — Refactoring with tests as a safety net (medium)

Take `TacheRepository` from the [level 02 mini-project](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.en.md). First write a characterization test for its `trouverParUtilisateur()` method (documenting its current behavior), then refactor its implementation (for example, simplifying how the SQL query is built) while checking the test stays green at every step.

## Exercise 4 — Detecting an N+1 problem in review (medium)

Review this code and identify the performance problem, explaining it the way you would in a review comment:
```php
$commandes = Order::all();
foreach ($commandes as $commande) {
    echo $commande->user->name;
}
```

## Exercise 5 — Conducting a complete review (hard)

Choose a controller over 50 lines long from one of this training's mini-projects (for example `AnnonceController` from level 07 or 09). Write a complete review structured around the lesson's 6 layers, with at least one comment per relevant layer (some layers may have "nothing to flag" — say so explicitly rather than omitting them).

---

*(Reflective module — an indicative answer key is provided to guide your thinking.)*

See [solutions/README.md](solutions/README.en.md).
