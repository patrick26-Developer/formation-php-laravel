# Running the Application

## Launch the app

```bash
php artisan serve
```

Open `http://localhost:8000`.

## Test account

Grab a generated user's email via Tinker:
```bash
php artisan tinker
>>> \App\Models\User::first()->email
```
Breeze factory default password: `password`.

## Using the platform

- **Browse/search/filter/sort** listings (public, no login required).
- **Contact a seller** via the form at the bottom of a listing (public) — triggers a notification to the seller.
- **Log in**, then **post a listing** with a photo.
- **Edit/delete** a listing: only visible and authorized for its owner (`AnnoncePolicy`).
- **Add/remove favorites** (star button on a listing, logged-in users only).

## Verifying authorization (Policy)

Log in as user A, note the edit URL for a listing that doesn't belong to them (`/annonces/{id}/modifier`). Log out, log in as a different user B, and go directly to that URL: Laravel must respond with **403 Forbidden**, and no "Edit" link should even be visible to B on that listing (`@can` in the view).

## Verifying the notification

Send a contact message on a listing. Check `storage/logs/laravel.log` (with `MAIL_MAILER=log`) to see the generated email, then log in as that listing's owner and check the notification counter in the menu.

## Verifying file cleanup

Note the stored filename for a listing's image (`storage/app/public/annonces/...`). Delete the listing from the interface. Verify the file has indeed disappeared from disk (the `deleting` Model Event, module 07.6).

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
