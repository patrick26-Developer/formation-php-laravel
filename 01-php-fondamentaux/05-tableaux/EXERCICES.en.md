# Exercises — 01.5 Arrays

## Exercise 1 — Basic manipulations (easy)

Create an array `$courses` with 5 items. Add a sixth one, print the total number of items, check whether "milk" is among them, then remove the first element with `array_shift()`.

## Exercise 2 — Address book (easy)

Create an associative array representing a person (`nom`, `email`, `telephone`). Print each piece of information with a `foreach ($personne as $cle => $valeur)` loop.

## Exercise 3 — The functional trio (medium)

With `$prix = [19.99, 5.50, 120.00, 8.75, 45.00];`:

1. Use `array_map` to get an array of tax-included prices (+20%).
2. Use `array_filter` to keep only tax-included prices above €10.
3. Use `array_reduce` to calculate the total sum of the filtered tax-included prices.

Do it as a single chain of calls if possible.

## Exercise 4 — Multidimensional array (medium)

Create an array of 4 students, each with `nom` and `notes` (an array of 3 grades). For each student, calculate and print their average. Finally print the name of the student with the best average.

## Exercise 5 — Custom sorting (hard)

Reuse the students array from exercise 4. Use `usort()` with a custom comparison function to sort the array by descending average, then print the ranking.

---

Compare with [solutions/](solutions/) once done.
