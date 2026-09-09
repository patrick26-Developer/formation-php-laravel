# Exercises — 06.3 The Blade Templating Engine

## Exercise 1 — Display and escaping (easy)

Create a route that passes a variable containing `<script>alert('x')</script>` to a view. Display it with `{{ }}` then with `{!! !!}`, and observe the difference in the page's source code.

## Exercise 2 — Control structures (easy)

Create a view displaying a list of products (an array passed from the controller), with a "No products" message if the list is empty, otherwise a bulleted list with each one's price.

## Exercise 3 — Layout with inheritance (medium)

Create `layouts/app.blade.php` with a `@yield('titre')` and `@yield('contenu')`. Create two different views that extend it, each with its own title and content.

## Exercise 4 — Reusable Blade component (medium)

Create a `<x-carte>` component accepting a slot and a `titre` prop, displaying a simple bordered card. Use it at least twice in the same view with different content.

## Exercise 5 — Complete form with errors (hard)

Create a creation form (POST) with `@csrf`, displaying validation errors per field with `@error`. Simulate a redirect with errors from the controller (`return back()->withErrors(['titre' => 'The title is required.'])`) and check the display.

---

See [solutions/README.md](solutions/README.en.md) for the answer key.
