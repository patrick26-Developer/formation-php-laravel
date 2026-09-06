# Exercices — 06.3 Le moteur de templates Blade

## Exercice 1 — Affichage et échappement (facile)

Créez une route qui passe une variable contenant `<script>alert('x')</script>` à une vue. Affichez-la avec `{{ }}` puis avec `{!! !!}`, et observez la différence dans le code source de la page.

## Exercice 2 — Structures de contrôle (facile)

Créez une vue affichant une liste de produits (tableau passé depuis le contrôleur), avec un message "Aucun produit" si la liste est vide, sinon une liste à puces avec le prix de chacun.

## Exercice 3 — Layout avec héritage (moyen)

Créez `layouts/app.blade.php` avec un `@yield('titre')` et `@yield('contenu')`. Créez deux vues différentes qui l'étendent, chacune avec son propre titre et contenu.

## Exercice 4 — Composant Blade réutilisable (moyen)

Créez un composant `<x-carte>` acceptant un slot et une prop `titre`, affichant une carte simple avec bordure. Utilisez-le au moins deux fois dans une même vue avec des contenus différents.

## Exercice 5 — Formulaire complet avec erreurs (difficile)

Créez un formulaire de création (POST) avec `@csrf`, affichant les erreurs de validation par champ avec `@error`. Simulez une redirection avec erreurs depuis le contrôleur (`return back()->withErrors(['titre' => 'Le titre est requis.'])`) et vérifiez l'affichage.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
