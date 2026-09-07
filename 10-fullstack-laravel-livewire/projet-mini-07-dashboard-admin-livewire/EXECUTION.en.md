# Running the Application

## Run the tests

```bash
php artisan test --filter=AnnoncesTableTest
```

## Launch the application

```bash
php artisan serve
```

Log in with the account promoted to administrator during installation, then open `http://localhost:8000/admin`.

## Using the dashboard

- **Search** for a title: results filter after a short pause (300ms), with no page reload.
- **Filter** by category or status: instant update.
- **Sort** by clicking "Title" or "Price": the arrow indicates the active column and direction.
- **Activate/Deactivate** a listing: the status changes immediately in the table, **and** the statistics widget at the top of the page updates on its own.
- **Delete**: a JavaScript confirmation box (Alpine, no server request) appears first; only clicking "OK" actually triggers deletion on the server.

## Verifying state persistence in the URL

Perform a search, change page, then fully refresh the page (F5): the search, sort, and page number should be preserved — visible directly in the URL (`?recherche=...&tri=...&page=...`).

## Verifying communication between components

Open your browser's network tools. Click "Deactivate" on a listing: a single Livewire request goes to the server, but **two areas of the page** update in the response (the table row and the statistics widget) — proof that the `statistiques-modifiees` event correctly notified the second component.

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
