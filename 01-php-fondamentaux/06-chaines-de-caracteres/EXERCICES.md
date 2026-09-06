# Exercices — 01.6 Chaînes de caractères et regex

## Exercice 1 — Nettoyage de saisie (facile)

Une variable `$saisie = "   Alice DUPONT  ";` contient une saisie utilisateur mal formatée. Nettoyez les espaces superflus et mettez-la au format "Alice Dupont" (prénom capitalisé, nom de famille en minuscules sauf la première lettre).

## Exercice 2 — Slug d'article de blog (moyen)

Écrivez une fonction `creerSlug(string $titre): string` qui transforme `"Les 10 Meilleures Astuces PHP !"` en `"les-10-meilleures-astuces-php"` (minuscules, espaces remplacés par des tirets, ponctuation supprimée). Utilisez `strtolower`, `preg_replace` et `trim`.

## Exercice 3 — Extraction de hashtags (moyen)

À partir d'un texte `"J'adore #PHP et #Laravel, c'est #Génial"`, utilisez `preg_match_all` pour extraire tous les hashtags dans un tableau (`["#PHP", "#Laravel", "#Génial"]`).

## Exercice 4 — Validateur de format téléphone (difficile)

Écrivez une fonction `estTelephoneValide(string $numero): bool` qui vérifie qu'un numéro de téléphone français est au format `06 12 34 56 78` ou `0612345678` (10 chiffres commençant par 0, avec ou sans espaces). Utilisez une regex.

## Exercice 5 — Statistiques de texte (difficile)

Écrivez un script qui, à partir d'un paragraphe de texte, affiche : le nombre de mots (`explode` sur les espaces), le nombre de caractères (sans les espaces), et le mot le plus long.

---

Comparez avec [solutions/](solutions/) une fois terminé.
