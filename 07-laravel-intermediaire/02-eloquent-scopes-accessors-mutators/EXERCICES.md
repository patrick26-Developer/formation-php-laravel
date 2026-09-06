# Exercices — 07.2 Scopes, accessors, mutators

## Exercice 1 — Scope local simple (facile)

Ajoutez un scope `recents` à `Article` retournant les articles créés dans les 7 derniers jours (`where('created_at', '>=', now()->subDays(7))`).

## Exercice 2 — Scope avec paramètre (facile)

Ajoutez un scope `parAuteur($nom)` (si vous avez un champ auteur, sinon simulez avec `parCategorie($id)`). Chaînez-le avec `publies()`.

## Exercice 3 — Accessor calculé (moyen)

Ajoutez un accessor `dureeLecture` sur `Article`, estimant le temps de lecture en minutes (`str_word_count($this->contenu) / 200`, arrondi à l'entier supérieur, minimum 1).

## Exercice 4 — Mutator de normalisation (moyen)

Ajoutez un mutator sur `email` d'un modèle `User`-like (ou simulez avec `Category::nom`) qui force le stockage en minuscules, avec un accessor qui capitalise la première lettre à l'affichage.

## Exercice 5 — Scope global documenté (difficile)

Ajoutez un scope global sur `Article` masquant les articles archivés (nouvelle colonne `archive` boolean). Documentez en commentaire PHPDoc au-dessus de la classe pourquoi ce choix a été fait globalement plutôt que localement, et montrez comment un développeur pourrait explicitement inclure les archivés malgré le scope global (`withoutGlobalScope`).

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
