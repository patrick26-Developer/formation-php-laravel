# Commands — Exercise 1

```bash
composer require --dev friendsofphp/php-cs-fixer
./vendor/bin/php-cs-fixer fix
```

Fixes automatically applied to `avant/src/Exemple.php` (see
`apres/src/Exemple.php` for the result):
- Class/method brace moved to its own line.
- `array(1,2,3)` → `[1, 2, 3]` (the `array_syntax` rule).
- Indentation standardized to 4 spaces.
- Added the missing `public` visibility keyword on `total()` (required by PSR-12).
- A space added around `=`.
