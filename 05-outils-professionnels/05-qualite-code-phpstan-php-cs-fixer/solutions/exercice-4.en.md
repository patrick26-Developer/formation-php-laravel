# Solution — Exercise 4

```bash
cd grand-projet-01-mini-framework-mvc-avec-api
composer require --dev phpstan/phpstan

# Level 0: basic checks (unknown variables, calls to nonexistent
# functions/classes) — expected: 0 or very few errors, since the large
# project's code is already clean.
./vendor/bin/phpstan analyse src --level 0

# Level 3: adds checking of declared return types and uninitialized
# properties — expected: still few or no errors, since the project
# already types systematically (declare(strict_types=1) everywhere).

# Level 6: requires ALL parameters and return types to be explicitly
# declared (no implicit "mixed" type tolerated without saying so).
./vendor/bin/phpstan analyse src --level 6
# Possible typical error: a Vue::afficher() method with a $donnees array
# with no detail about its content (missing PHPDoc @param array<string, mixed>)
# — PHPStan may flag this as a type imprecision at this level.

# Level 8: the strictest for common use — even checks for the absence of
# an explicit check before accessing a potentially null value.
./vendor/bin/phpstan analyse src --level 8
# Typical error: in TacheApiController::modifier(), accessing
# $tache['titre'] after a first call to trouver() that could have
# returned null (even if a check was already done just before, PHPStan
# can't always "follow" this logic depending on how it's written).

# Possible fix for a level-6+ error: add a PHPDoc annotation specifying
# the shape of the array returned by TacheRepository::trouver():
#
# /**
#  * @return array{id: int, titre: string, description: ?string, terminee: int, creee_le: string}|null
#  */
# public function trouver(int $id): ?array
```

General observation: the more strictly a project types from the start
(`declare(strict_types=1)`, typed promoted constructors, explicit
returns — all practices already applied in this large project), the
smaller the gap between PHPStan's low and high levels. This is concrete
proof that module 03.5's best practices pay off directly in measurable
quality.
