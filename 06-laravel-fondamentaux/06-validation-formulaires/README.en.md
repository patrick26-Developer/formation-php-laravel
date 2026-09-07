# 06.6 — Form Validation

> **Status:** ✅ Available

## 🎯 Objectives

- Validate incoming data with Laravel's validation rules.
- Understand the automatic redirect-with-errors flow.
- Use Form Requests to extract validation out of controllers.
- Know the most commonly used validation rules.

## 📋 Prerequisites

[06.5 — Migrations, Seeders, Factories](../05-migrations-seeders-factories/README.en.md), [01.7 — HTML Forms and GET/POST](../../01-php-fondamentaux/07-formulaires-http-get-post/README.en.md)

## ⏱️ Estimated duration

2h.

## 📖 Theory

### Validating directly in the controller

```php
public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:150',
        'email' => 'required|email',
        'age' => 'required|integer|min:18|max:120',
    ]);

    Tache::create($validated);

    return redirect()->route('taches.index');
}
```

> 💡 Recognize [module 01.7](../../01-php-fondamentaux/07-formulaires-http-get-post/README.en.md): you manually checked `trim($_POST['titre']) === ''`, `filter_var($email, FILTER_VALIDATE_EMAIL)`, an age range. Laravel expresses the same rules declaratively, in one line per field.

**If validation fails**, Laravel **automatically** redirects back to the previous page, with:
- Errors available via `$errors` in the view (used by `@error`, module 06.3).
- The previously entered values available via `old('field')`.

**You write no code to handle this failure** — unlike the manual `$errors = []; if (...) { $errors[] = ...; }` flow from module 01.7, fully automated here.

### Common validation rules

| Rule | Effect |
|---|---|
| `required` | The field must be present and non-empty |
| `string` / `integer` / `numeric` / `boolean` | Checks the type |
| `email` | Valid email format (equivalent to `filter_var(..., FILTER_VALIDATE_EMAIL)`) |
| `min:x` / `max:x` | Minimum/maximum length (strings) or value (numbers) |
| `unique:table,column` | The value must not exist anywhere else in this column |
| `exists:table,column` | The value must exist in this table (useful for a `categorie_id`, for example) |
| `confirmed` | Requires a matching `xxx_confirmation` field (password) |
| `nullable` | The field can be absent/empty without triggering `required` |
| `date` | Must be a valid date |
| `in:a,b,c` | The value must be one of those listed |

```php
$request->validate([
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:8|confirmed',
    'status' => 'required|in:pending,shipped,delivered',
]);
```

### Custom error messages

```php
$request->validate(
    [
        'titre' => 'required|max:150',
    ],
    [
        'titre.required' => 'The task title is required.',
        'titre.max' => 'The title cannot exceed :max characters.',
    ]
);
```

### Form Requests: extracting validation out of the controller

For complex or reused validation rules, Laravel recommends a dedicated class rather than overloading the controller.

```bash
php artisan make:request StoreTacheRequest
```

```php
// app/Http/Requests/StoreTacheRequest.php
class StoreTacheRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or an authorization check (module 07.5)
    }

    public function rules(): array
    {
        return [
            'titre' => 'required|string|max:150',
            'description' => 'nullable|string',
        ];
    }
}
```

```php
// The controller becomes very short: Laravel validates BEFORE store() even runs
public function store(StoreTacheRequest $request)
{
    Tache::create($request->validated());
    return redirect()->route('taches.index');
}
```

> 📌 **Professional best practice**: as soon as a form exceeds 3-4 rules, or its validation is reused (create **and** edit), extract it into a Form Request. This follows the single responsibility principle (module 03.5): the controller orchestrates, the Form Request validates.

## ✅ Key takeaways

- `$request->validate([...])` automatically fails with redirect, errors, and old values — no manual code needed.
- Rules combine type, presence, length, uniqueness, database existence, etc., via a declarative syntax.
- A Form Request extracts validation out of the controller for non-trivial cases, following the single responsibility principle.
- This automation directly replaces module 01.7's manual flow, while remaining just as rigorous.

## ➡️ Going further

- [laravel.com/docs — Validation](https://laravel.com/docs/validation)
- [Module 07.3 — Middlewares and Form Requests](../../07-laravel-intermediaire/03-middlewares-form-requests/README.md) *(French only)*

## 📝 Exercises

See [EXERCICES.md](EXERCICES.en.md).

---

**Previous:** [06.5 — Migrations, Seeders, Factories](../05-migrations-seeders-factories/README.en.md) · **Next:** [06.7 — Full Laravel CRUD](../07-crud-complet-laravel-tri-filtre-recherche/README.en.md)
