# Exercises — 07.6 File Uploads and Storage

## Exercise 1 — First upload (easy)

Add a nullable `image` column to `articles`. Add a file field to the creation form, validate it (`image|mimes:jpg,png|max:2048`), store it on the `public` disk.

## Exercise 2 — Displaying the image (easy)

Add an `imageUrl` accessor and display the image on the article's page (with a default image if absent).

## Exercise 3 — Replacing an image (medium)

On the edit form, allow changing the image. Delete the old one from disk before storing the new one.

## Exercise 4 — Strict validation (medium)

Add `dimensions:min_width=300,min_height=200` to the validation, to reject images that are too small. Test with a non-compliant image and check the error message.

## Exercise 5 — Cleanup on deletion (hard)

Use a **Model Event** (`deleting`, in the `Article` model's `booted()`) rather than a line in the controller, to automatically delete the image file as soon as an article is deleted, **no matter where the deletion comes from** (controller, Tinker, an Artisan command...). Explain in a comment the benefit of this approach compared to deletion coded only in `destroy()`.

---

See [solutions/README.md](solutions/README.md) for the answer key.
