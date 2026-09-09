# Exercises — 07.5 Authorization: Policies and Gates

## Exercise 1 — First Policy (easy)

Generate `ArticlePolicy` with `update`/`delete` restricted to the author. Test it with `$this->authorize()` in the controller.

## Exercise 2 — Checking in a view (easy)

Display the "Edit"/"Delete" links on an article's page only with `@can`/`@cannot`, for the authorized user.

## Exercise 3 — Global Gate (medium)

Create an `acceder-admin` Gate restricted to users with `est_admin = true`. Protect an `/admin` route with `Route::get(...)->can('acceder-admin')`.

## Exercise 4 — Policy with a combined rule (medium)

Modify `ArticlePolicy::delete()` to authorize either the author or an admin. Test all three cases (author, admin, third party).

## Exercise 5 — Form Request delegating to the Policy (hard)

Rewrite `UpdateArticleRequest::authorize()` to delegate entirely to `$this->user()->can('update', $this->route('article'))`, removing any duplicated logic that previously existed in the Form Request. Explain in a comment the benefit of this centralization if the authorization rule ever changes.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
