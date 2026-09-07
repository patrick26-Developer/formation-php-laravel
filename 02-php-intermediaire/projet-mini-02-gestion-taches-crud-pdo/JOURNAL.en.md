# Build Journal

> This journal retraces the project's construction in the logical order followed, so you can reproduce the same approach.

## Step 1 — The data schema

Before any PHP code, `sql/schema.sql` defines two tables: `utilisateurs` (users) and `taches` (tasks), linked by a `utilisateur_id` foreign key. This `FOREIGN KEY ... ON DELETE CASCADE` constraint guarantees that an orphan task (without a user) can never be created, and that deleting a user automatically deletes their tasks.

Deliberately, **no password is hardcoded in the SQL**: `seed.php` creates the demo user via `password_hash()`, consistent with the rule from [module 02.5](../05-sessions-cookies-authentification-maison/README.en.md).

## Step 2 — The centralized connection (`Database.php`)

Directly reuses the Singleton pattern from [module 02.8](../08-pdo-bases-de-donnees-mysql/README.en.md): a single PDO connection per HTTP request, read from `config.php` (not version-controlled) rather than hardcoded — the first time in this training that a real configuration/code separation is applied.

## Step 3 — Authentication (`Auth.php`)

`Auth::connecter()` checks the email and password (`password_verify()`), then calls `session_regenerate_id(true)` before writing to the session — an extra precaution not mentioned in module 02.5: regenerating the session identifier on login prevents a **session fixation** attack (an attacker who had fixed a victim's session ID *before* their login cannot exploit it afterward, since the ID changes).

`Auth::exigerConnexion()` reproduces the homemade middleware from module 02.5, called at the very start of every protected page (`index.php`, `creer.php`, `modifier.php`, `supprimer.php`).

## Step 4 — CSRF protection (`CsrfHelper.php`)

The token and its verification (module 02.6) are isolated in a dedicated class rather than duplicated on every page. `CsrfHelper::exigerJetonValide()` is called at the very start of processing for **every** POST form in the project (login, create, edit, delete) — no action that modifies data escapes this check.

## Step 5 — CRUD with sort/filter/search (`TacheRepository.php`)

Directly reuses the structure from [module 02.9](../09-crud-complet-pdo-tri-filtre-recherche/README.en.md), with one important addition: **every method receives `utilisateurId` and includes it in its `WHERE` clause**. This isn't optional — it's what guarantees that a logged-in user can never read, edit, or delete another user's tasks, even by manually tampering with the `id` in the URL (`modifier.php?id=42`): if task 42 doesn't belong to the current user, `trouver()` returns `null` and the page responds with 404.

## Step 6 — The web pages (`public/`)

Every page follows the same skeleton: `session_start()` → include the needed classes → `Auth::exigerConnexion()` → page logic → HTML output with systematic `htmlspecialchars()` on every displayed piece of data. `index.php` is the densest page: it reads the `?tri=`, `?ordre=`, `?recherche=`, `?statut=`, `?page=` parameters from the URL and passes them to `TacheRepository::lister()`, exactly as described in module 02.9's usage example.

## Going further (out of scope for this mini-project)

This project doesn't yet use Composer/autoloading (module 02.7 was covered in theory, but not applied here): every file is included manually with `require_once`, so you can clearly see this mechanism one last time before it gets automated starting at [Level 03](../../03-php-avance/README.md). There are also no automated tests (arriving in [module 03.3](../../03-php-avance/03-tests-unitaires-phpunit/README.md)) and no "smart" pagination (truncated display for many pages) — deliberately kept simple to stay focused on level 02's objectives.
