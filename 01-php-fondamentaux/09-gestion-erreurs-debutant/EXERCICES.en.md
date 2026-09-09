# Exercises — 01.9 Introduction to Error Handling

## Exercise 1 — Observing error levels (easy)

Write a script that accesses an undefined variable (`echo $inexistante;`) with `error_reporting(E_ALL)` enabled. Observe the message. Then comment out this line and observe the difference.

## Exercise 2 — Safe divider (easy)

Write a function `diviserSecurise(float $a, float $b): float` that throws an `Exception` if `$b` is 0, otherwise returns the result. Call it inside a `try`/`catch` with several values, including 0.

## Exercise 3 — Validation with an exception (medium)

Write a function `validerAge(int $age): int` that throws an `Exception` with an explicit message if the age is negative or greater than 150, otherwise returns the age. Test it with a `foreach` over several values (`[25, -5, 200, 40]`), catching each exception individually so the loop continues despite the errors.

## Exercise 4 — `finally` in action (medium)

Simulate opening a "resource" (a simple `$ressourceOuverte = true;` variable) in a `try` block, trigger an exception in the middle, and use `finally` to print "Resource closed" and set `$ressourceOuverte = false;`, guaranteeing this cleanup happens even on error.

## Exercise 5 — Guided debugging (hard)

This code contains a bug that causes a fatal error. Use `var_dump()` at various points to precisely locate the source of the problem before fixing it.

```php
<?php
function calculerMoyenne(array $notes): float {
    $total = 0;
    foreach ($notes as $note) {
        $total += $note;
    }
    return $total / count($notes);
}

$notesClasse = [];
echo calculerMoyenne($notesClasse);
```

---

Compare with [solutions/](solutions/README.en.md) once done.
