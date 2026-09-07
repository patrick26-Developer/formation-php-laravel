# Running the Application

## Run the tests

```bash
php artisan test --filter=AnalyserLogsCommandTest
```

## Generate test logs, then analyze them

```bash
php artisan tinker
>>> logger()->error('Demo error 1');
>>> logger()->error('Demo error 2');
>>> logger()->warning('Demo warning');
>>> logger()->info('Demo info');
>>> exit
```

```bash
php artisan logs:analyser
```
```
Analyzing: /path/to/storage/logs/laravel.log

+---------+-------------+
| Level   | Occurrences |
+---------+-------------+
| ERROR   | 2           |
| WARNING | 1           |
| INFO    | 1           |
+---------+-------------+

Total: 4 entries.
```

## Filtering by level

```bash
php artisan logs:analyser --niveau=error
```
```
+--------+-------------+
| Level  | Occurrences |
+--------+-------------+
| ERROR  | 2           |
+--------+-------------+

Total: 2 entries.
```

## Analyzing a specific file

```bash
php artisan logs:analyser storage/logs/laravel-2026-09-01.log
```

## Checking the exit code (useful in scripts/CI)

```bash
php artisan logs:analyser fichier-inexistant.log; echo "Exit code: $?"
# Exit code: 1
```

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
