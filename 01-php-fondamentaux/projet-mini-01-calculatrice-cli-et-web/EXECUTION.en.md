# Execution

## Command-line interface (CLI)

From the project root:

```bash
php src/cli.php <number1> <operation> <number2>
```

Examples:

```bash
php src/cli.php 10 + 5     # 10 + 5 = 15
php src/cli.php 20 / 4     # 20 / 4 = 5
php src/cli.php 8 / 0      # Error: Cannot divide by zero.
```

Exit codes: `0` on success, `1` on error (missing arguments, invalid operation, division by zero) — useful if you call this script from another program or a pipeline.

## Web interface

From the `src/web/` folder, start PHP's built-in server:

```bash
cd src/web
php -S localhost:8000
```

Then open `http://localhost:8000` in your browser. Fill in the form and click "Calculate".

## Testing error cases

- CLI: `php src/cli.php 10 % 5` → "Unknown operation" error message.
- Web: enter `abc` in a number field → "Both values must be numbers" message.
- Both: attempt a division by 0 → a consistent error message on both interfaces, since they share the same `diviser()` function.

**See also:** [JOURNAL.md](JOURNAL.en.md) to understand how this shared behavior was built.
