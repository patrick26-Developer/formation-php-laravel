# Exercises — 07.4 Authentication with Breeze/Fortify

## Exercise 1 — Installing Breeze (easy)

On a new Laravel project, install Breeze (Blade variant), migrate, and test registering then logging in a user via the generated interface.

## Exercise 2 — Exploring the generated code (easy)

Open `app/Http/Controllers/Auth/RegisteredUserController.php` and `AuthenticatedSessionController.php`. Identify the line that hashes the password and the one that regenerates the session after login.

## Exercise 3 — Protecting the Level 06 blog (medium)

Install Breeze on the [Blog mini-project](../../06-laravel-fondamentaux/projet-mini-03-blog-crud-laravel/README.en.md). Protect the article creation/edit/delete routes with `middleware('auth')`, leaving `index` and `show` public.

## Exercise 4 — Displaying the logged-in user (medium)

Add to the blog's layout an `@auth`/`@else` block displaying either the logged-in user's name with a logout link, or login/registration links.

## Exercise 5 — Linking articles to their author (hard)

Add a `user_id` column to `articles`. Modify `ArticleController::store()` to automatically associate the article with `$request->user()`. Display the author's name on each article's page (`$article->user->name`, with eager loading `with('user')`).

---

See [solutions/README.md](solutions/README.md) for the answer key.
