# Exercises — 01.6 Strings and Regular Expressions

## Exercise 1 — Input cleanup (easy)

A variable `$saisie = "   Alice DUPONT  ";` holds badly formatted user input. Trim the extra whitespace and format it as "Alice Dupont" (capitalized first name, lowercase last name except its first letter).

## Exercise 2 — Blog post slug (medium)

Write a function `creerSlug(string $titre): string` that turns `"Les 10 Meilleures Astuces PHP !"` into `"les-10-meilleures-astuces-php"` (lowercase, spaces replaced with hyphens, punctuation removed). Use `strtolower`, `preg_replace`, and `trim`.

## Exercise 3 — Hashtag extraction (medium)

From a text `"J'adore #PHP et #Laravel, c'est #Génial"`, use `preg_match_all` to extract all hashtags into an array (`["#PHP", "#Laravel", "#Génial"]`).

## Exercise 4 — Phone number format validator (hard)

Write a function `estTelephoneValide(string $numero): bool` that checks a French phone number is in the format `06 12 34 56 78` or `0612345678` (10 digits starting with 0, with or without spaces). Use a regex.

## Exercise 5 — Text statistics (hard)

Write a script that, given a paragraph of text, prints: the number of words (`explode` on spaces), the number of characters (excluding spaces), and the longest word.

---

Compare with [solutions/](solutions/) once done.
