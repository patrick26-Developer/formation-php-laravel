# Exercises — 01.7 HTML Forms and GET/POST

> For these exercises, run `php -S localhost:8000` in your exercise's folder, then open `http://localhost:8000/file-name.php` in your browser.

## Exercise 1 — Search form with GET (easy)

Create a form with a single text field `recherche`, method `GET`, that submits to itself. Print "You're searching for: [term]" if the parameter is present in the URL. Observe how the term appears in the URL after submission.

## Exercise 2 — Calculator via a form (medium)

Create a `POST` form with two numeric fields (`nombre1`, `nombre2`) and a dropdown (`select`) to choose the operation (`+`, `-`, `*`, `/`). Handle the calculation on the PHP side with a `match`, handling the division-by-zero case.

## Exercise 3 — Form with full validation (medium)

Create a simple registration form (`nom`, `email`, `age`). Validate that: the name isn't empty, the email is valid (`filter_var`), the age is a number between 18 and 120. Display each error separately, and re-display the form pre-filled with the already-entered values on error (as in the lesson's example).

## Exercise 4 — XSS trap (hard)

1. Create a form with a `commentaire` field in `POST`, and display it **without** `htmlspecialchars()`.
2. In the field, deliberately enter: `<b>test</b>` then `<script>alert('hacked')</script>`. Observe what happens in the browser.
3. Fix the code with `htmlspecialchars()` and try the same two inputs again. Explain in a comment the difference in behavior.

## Exercise 5 — Mini poll (hard)

Create a form with checkboxes (`checkbox`, name="langages[]") allowing several favorite programming languages to be selected. Handle the received array on the PHP side (`$_POST['langages']`) and display the chosen list as an HTML list (`<ul>`), escaping every value.

---

Compare with [solutions/](solutions/README.en.md) once done.
