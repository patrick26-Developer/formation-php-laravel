# Execution

## Launching the application

```bash
php artisan serve
```

Open `http://localhost:8000` (automatically redirects to `/articles`).

## Using the blog

- **Browse articles**: a paginated list (6 per page) of published articles.
- **Search**: a search field filtering on the title.
- **Filter by category**: a dropdown menu.
- **Sort**: "Title"/"Date" links at the top of the list, clickable to reverse the order.
- **View an article**: click its title, shows the full content and its comments.
- **Comment**: a form at the bottom of an article's page.
- **Create/edit/delete an article**: "+ New article" (menu) and "Edit"/"Delete" (article page) links.
- **Manage categories**: the "Categories" menu page — creation and deletion (deleting one also removes all linked articles, via `cascadeOnDelete`).

## Verifying eager loading (no N+1 problem)

Enable the Laravel Debugbar (`composer require --dev barryvdh/laravel-debugbar`) or check `storage/logs/laravel.log` with the query driver set to `log`: the `/articles` page should run **only one query** to load the articles along with their categories (`with('categorie')`), not one query per article.

## Testing validation

Try creating an article with an already-used `slug`: the form should redisplay with the `alpha_dash`/`unique` error under the right field, and your other inputs (title, content) should remain pre-filled (`old()`).

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
