# Exercises — 01.8 Files, Includes and Organization

## Exercise 1 — Simple log (easy)

Write a script that appends a timestamped line (`date('Y-m-d H:i:s')`) to a `journal.txt` file on every run, without overwriting previous lines. Run it 3 times and check the file's content.

## Exercise 2 — Reading and counting (easy)

Create a `mots.txt` file containing several words (one per line). Write a script that reads the file and prints the total number of lines and the total number of characters.

## Exercise 3 — Separating configuration and functions (medium)

Create three files: `config.php` (a `TVA_TAUX` constant), `fonctions.php` (a `calculerTTC` function), and `index.php`, which includes both with `require_once` and uses them. Use `__DIR__` for every path.

## Exercise 4 — The multiple-inclusion trap (medium)

Create an `outils.php` file with a function. In `index.php`, include it twice with `require` (not `require_once`). Observe the error you get, then fix it with `require_once`.

## Exercise 5 — Mini template system (hard)

Create `partials/header.php` and `partials/footer.php` (simple HTML), and an `index.php` that includes them around dynamic content (a `$titre` variable displayed in the header's `<title>`). Use `__DIR__`-based paths.

---

Compare with [solutions/](solutions/) once done.
