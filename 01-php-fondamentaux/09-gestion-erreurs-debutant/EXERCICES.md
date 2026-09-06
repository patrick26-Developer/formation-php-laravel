# Exercices — 01.9 Introduction à la gestion d'erreurs

## Exercice 1 — Observer les niveaux d'erreurs (facile)

Écrivez un script qui accède à une variable non définie (`echo $inexistante;`) avec `error_reporting(E_ALL)` activé. Observez le message. Puis commentez cette ligne et observez la différence.

## Exercice 2 — Diviseur sécurisé (facile)

Écrivez une fonction `diviserSecurise(float $a, float $b): float` qui lève une `Exception` si `$b` vaut 0, sinon retourne le résultat. Appelez-la dans un `try`/`catch` avec plusieurs valeurs, y compris 0.

## Exercice 3 — Validation avec exception (moyen)

Écrivez une fonction `validerAge(int $age): int` qui lève une `Exception` avec un message explicite si l'âge est négatif ou supérieur à 150, sinon retourne l'âge. Testez-la avec un `foreach` sur plusieurs valeurs (`[25, -5, 200, 40]`), en capturant chaque exception individuellement pour que la boucle continue malgré les erreurs.

## Exercice 4 — `finally` en action (moyen)

Simulez l'ouverture d'une "ressource" (une simple variable `$ressourceOuverte = true;`) dans un bloc `try`, provoquez une exception au milieu, et utilisez `finally` pour afficher "Ressource fermée" et mettre `$ressourceOuverte = false;`, garantissant que ce nettoyage a bien lieu même en cas d'erreur.

## Exercice 5 — Débogage guidé (difficile)

Ce code contient un bug qui provoque une erreur fatale. Utilisez `var_dump()` à différents endroits pour localiser précisément l'origine du problème avant de le corriger.

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

Comparez avec [solutions/](solutions/) une fois terminé.
