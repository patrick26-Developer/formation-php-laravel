# Build Journal

## Step 1 — An Artisan command that never touches Eloquent

This project deliberately shows that Artisan doesn't systematically involve a database: `AnalyserLogsCommand` references no model, no migration. It's a useful reminder after several levels (06 to 10) where Artisan was almost always tied to `make:model`/`migrate` — its real nature is that of a general-purpose CLI framework, inherited from the Symfony Console component.

## Step 2 — The signature, a declarative equivalent to parsing `$argv`

```
{chemin? : Path to the log file}
{--niveau= : Only count a specific level}
```
Compare this with [module 01.9](../../01-php-fondamentaux/09-gestion-erreurs-debutant/README.en.md) and the use of `$argv` in previous CLI projects (level 12, projects 1 and 2): where a native PHP script has to manually validate the presence of each argument (`if ($argv[1] === null) { ... }`), Artisan parses, validates the type, and documents automatically (`?` = optional, `--niveau=` = option with a value) — visible directly via `php artisan help logs:analyser`.

## Step 3 — Simple but explicit level detection

`compterParNiveau()` looks for the substring `.ERROR:` etc. in each line, relying on Laravel's standard log format (`[date] environment.LEVEL: message`). This isn't a generic parser for every imaginable log format — a deliberate choice: this project specifically targets Laravel logs, not a universal tool, consistent with the YAGNI principle already met in [module 08.5](../../08-laravel-avance/05-architecture-modulaire/README.en.md).

## Step 4 — Returning usable exit codes

`self::SUCCESS` (0) and `self::FAILURE` (1) make this command usable in a shell script or a CI/CD pipeline step (module 11.3): `php artisan logs:analyser --niveau=critical; if [ $? -ne 0 ]; then alert; fi` becomes possible without having to parse the command's text output.

## Step 5 — Testing an Artisan command like a route

`AnalyserLogsCommandTest` uses `$this->artisan()`, the command equivalent of `$this->get()`/`$this->post()` for HTTP routes (module 08.3): the same Feature-testing principles (drive observable behavior, not internal details), adapted to a CLI interface rather than a web one.

## Going further (out of scope for this project)

No "abnormal spike" detection (comparison against a historical average) is implemented — a natural future addition would combine this project with sending a notification (module 07.7) when a threshold is exceeded.
