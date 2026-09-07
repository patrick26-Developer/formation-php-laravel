# 07.6 — File Uploads and Storage

> **Status:** ✅ Available

## 🎯 Objectives

- Understand Laravel's disk system (`Storage`).
- Handle file upload, storage, and deletion.
- Validate uploaded files (type, size).
- Display publicly stored files.

## 📋 Prerequisites

[07.5 — Authorization: Policies and Gates](../05-autorisations-policies-gates/README.en.md)

## ⏱️ Estimated duration

1h30.

## 📖 Theory

### Laravel's disk system

Laravel abstracts file storage behind a single interface (`Storage`), regardless of the actual backend (local disk, S3, etc.), configured in `config/filesystems.php`:

```php
// config/filesystems.php
'disks' => [
    'local' => ['driver' => 'local', 'root' => storage_path('app/private')],
    'public' => ['driver' => 'local', 'root' => storage_path('app/public'), 'url' => env('APP_URL').'/storage', 'visibility' => 'public'],
    's3' => ['driver' => 's3', /* ... */], // cloud storage, same API
],
```

> 💡 Switching disks (`local` → `s3` in production, for example) changes **nothing** in the application code: you always work with `Storage::disk('public')->...`. This is the same abstraction principle as PDO (module 02.8), which lets you switch database engines without rewriting queries.

### Making the `public` disk accessible from the web

```bash
php artisan storage:link
```

Creates a symbolic link from `public/storage` to `storage/app/public` — files on this disk become accessible via a URL, without directly exposing the `storage/` folder.

### Uploading a file

```php
// Validation
$request->validate([
    'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', // 2048 KB max
]);

// Storage
$path = $request->file('image')->store('articles', 'public');
// $path looks like: "articles/aBcD1234.jpg" (automatically generated name, no collisions)

Article::create([
    'titre' => $request->input('titre'),
    'image' => $path,
]);
```

> ⚠️ **Never trust the original filename** sent by the user (`$request->file('image')->getClientOriginalName()`) for actual storage: it may contain dangerous characters, or collide with an existing file. `store()` automatically generates a unique, safe name — the same caution as with any user data (module 02.6).

### Displaying a stored file

```php
// app/Models/Article.php
protected function imageUrl(): Attribute
{
    return Attribute::make(
        get: fn () => $this->image ? Storage::disk('public')->url($this->image) : null,
    );
}
```

```blade
@if ($article->image_url)
    <img src="{{ $article->image_url }}" alt="{{ $article->titre }}">
@endif
```

### Replacing and deleting a file

```php
public function update(Request $request, Article $article)
{
    if ($request->hasFile('image')) {
        // Delete the old file BEFORE saving the new one, to avoid
        // accumulating orphaned files on disk across successive edits
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->image = $request->file('image')->store('articles', 'public');
    }

    $article->save();
}
```

```php
// When deleting the article itself
public function destroy(Article $article)
{
    if ($article->image) {
        Storage::disk('public')->delete($article->image);
    }

    $article->delete();
}
```

> ⚠️ **Common pitfall**: deleting a database record **without** deleting its associated file on disk leaves orphaned files that accumulate indefinitely. Always clean up the file when deleting/replacing the record that references it.

## ✅ Key takeaways

- `Storage::disk('public')` abstracts physical storage, swappable (local/S3) without touching application code.
- `php artisan storage:link` makes the `public` disk accessible via a web URL.
- Systematically validate an uploaded file's type and size (`image`, `mimes:`, `max:`).
- Always delete the physical file when deleting/replacing the record that references it, to avoid orphaned files.

## ➡️ Going further

- [laravel.com/docs — File Storage](https://laravel.com/docs/filesystem)
- [laravel.com/docs — Validation (File Rules)](https://laravel.com/docs/validation#validating-files)

## 📝 Exercises

See [EXERCICES.md](EXERCICES.md) *(currently French only)*.

---

**Previous:** [07.5 — Policies and Gates](../05-autorisations-policies-gates/README.en.md) · **Next:** [07.7 — Notifications and Emails](../07-notifications-mail/README.en.md)
