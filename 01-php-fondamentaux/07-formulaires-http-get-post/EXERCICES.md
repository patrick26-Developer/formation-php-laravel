# Exercices — 01.7 Formulaires HTML et GET/POST

> Pour ces exercices, utilisez `php -S localhost:8000` dans le dossier de votre exercice, puis ouvrez `http://localhost:8000/nom-du-fichier.php` dans votre navigateur.

## Exercice 1 — Formulaire de recherche en GET (facile)

Créez un formulaire avec un seul champ texte `recherche`, méthode `GET`, qui s'auto-soumet vers lui-même. Affichez "Vous cherchez : [terme]" si le paramètre est présent dans l'URL. Observez comment le terme apparaît dans l'URL après soumission.

## Exercice 2 — Calculatrice via formulaire (moyen)

Créez un formulaire en `POST` avec deux champs numériques (`nombre1`, `nombre2`) et un menu déroulant (`select`) pour choisir l'opération (`+`, `-`, `*`, `/`). Traitez le calcul côté PHP avec un `match`, en gérant le cas de la division par zéro.

## Exercice 3 — Formulaire avec validation complète (moyen)

Créez un formulaire d'inscription simple (`nom`, `email`, `age`). Validez que : le nom n'est pas vide, l'email est valide (`filter_var`), l'âge est un nombre entre 18 et 120. Affichez chaque erreur séparément, et réaffichez le formulaire pré-rempli avec les valeurs déjà saisies en cas d'erreur (comme dans l'exemple du cours).

## Exercice 4 — Piège XSS (difficile)

1. Créez un formulaire avec un champ `commentaire` en `POST`, et affichez-le **sans** `htmlspecialchars()`.
2. Dans le champ, saisissez volontairement : `<b>test</b>` puis `<script>alert('piraté')</script>`. Observez ce qu'il se passe dans le navigateur.
3. Corrigez le code avec `htmlspecialchars()` et réessayez les deux mêmes saisies. Expliquez en commentaire la différence de comportement.

## Exercice 5 — Mini-sondage (difficile)

Créez un formulaire avec des cases à cocher (`checkbox`, name="langages[]") permettant de sélectionner plusieurs langages de programmation aimés. Traitez le tableau reçu côté PHP (`$_POST['langages']`) et affichez la liste choisie sous forme de liste HTML (`<ul>`), en échappant chaque valeur.

---

Comparez avec [solutions/](solutions/) une fois terminé.
