# Execution

## Launching the application

The web entry point is in `public/`. Start PHP's built-in server **from that folder**:

```bash
cd public
php -S localhost:8000
```

Then open `http://localhost:8000/connexion.php` in your browser.

## Logging in

Use the account created by `php src/seed.php` (see [INSTALLATION.md](INSTALLATION.en.md)):

- Email: `demo@example.com`
- Password: `demo1234`

## Using the application

- **Create a task**: "+ New task" button from the list.
- **Sort**: click the "Title", "Status", or "Created on" column headers — a second click reverses the order.
- **Search**: type a term in the search field (filters on the title).
- **Filter by status**: "All / In progress / Completed" dropdown.
- **Paginate**: page number links at the bottom of the list (5 tasks per page).
- **Edit/Delete**: links in the "Actions" column of each row.
- **Log out**: link at the top of the page — destroys the session.

## Testing isolation between users

Create a second user directly in the database (or adapt `seed.php`), log in with it, and verify that it sees **none** of the tasks created by `demo@example.com` — this is the expected behavior of `TacheRepository`, which systematically filters by `utilisateur_id`.

## Testing CSRF protection

Using the browser's developer tools, remove the hidden `jeton_csrf` field from a form (create, edit, or delete) before submitting it: the server should respond "403 Request rejected".

**See also:** [JOURNAL.md](JOURNAL.en.md) to understand how this protection was put in place.
