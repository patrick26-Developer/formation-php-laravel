# Exercises — 02.5 Sessions, Cookies, Homemade Authentication

> Run these exercises with `php -S localhost:8000` and test in a browser — sessions require real HTTP requests.

## Exercise 1 — Session visit counter (easy)

Create a page that counts and displays how many times it has been visited, using `$_SESSION`. Reload the page several times to check.

## Exercise 2 — Cookie preference (easy)

Create a form allowing a theme to be chosen ("light"/"dark"), stored in a cookie valid for 7 days. Display the active theme by reading `$_COOKIE`.

## Exercise 3 — Password hashing (medium)

Write a script that hashes a password entered via a form with `password_hash()`, displays the resulting hash, then checks via a second form whether an entered password matches this hash with `password_verify()`.

## Exercise 4 — Full login flow (medium)

Reusing the lesson's example (a directory simulated as a PHP array), build a complete flow: login form → verification → session → redirect to a protected page displaying the logged-in email → a logout link that destroys the session.

## Exercise 5 — Reusable homemade middleware (hard)

Create a file `exiger-connexion.php` containing a function `exigerConnexion(): void` that checks `$_SESSION['utilisateur_email']` and redirects to `connexion.php` if absent. Use this function (via `require_once` + a call) at the top of **two different protected pages**, to show its reusability.

---

Compare with [solutions/](solutions/) once done.
