# Exercises — 08.3 Testing with Pest and PHPUnit in Laravel

## Exercise 1 — First Feature test (easy)

Install Pest on the [level 07 mini-project](../../07-laravel-intermediaire/projet-mini-04-plateforme-annonces/README.en.md). Write a test checking that `/annonces` responds 200.

## Exercise 2 — Creation test (easy)

Write a test checking that a logged-in user can create a listing, using `assertDatabaseHas()`.

## Exercise 3 — Authorization test (medium)

Write two tests: a user can edit their own listing (successful redirect), another user cannot (403).

## Exercise 4 — Test with Mail::fake() (medium)

Write a test checking that sending a contact message correctly triggers a notification, using `Notification::fake()` and `Notification::assertSentTo()`, without sending a real email.

## Exercise 5 — Complete test suite for the Policy (hard)

Write a test suite covering ALL of `AnnoncePolicy`'s cases: the owner can edit, the owner can delete, a third party can neither edit nor delete, a logged-out user is redirected to login. Use `RefreshDatabase` and verify no test affects the next ones (run the suite several times in a row, the result order must be stable).

---

See [solutions/README.md](solutions/README.md) for the answer key.
