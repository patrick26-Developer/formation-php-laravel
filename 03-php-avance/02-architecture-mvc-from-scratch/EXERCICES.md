# Exercices — 03.2 Architecture MVC from scratch

## Exercice 1 — Routeur minimal (facile)

Implémentez la classe `Routeur` du cours. Ajoutez deux routes GET (`/` et `/a-propos`) avec des fonctions anonymes affichant un texte simple. Testez en simulant différentes valeurs de `$_SERVER['REQUEST_URI']`.

## Exercice 2 — Route avec paramètre dynamique (moyen)

Étendez `Routeur` pour supporter un paramètre dans le chemin, par exemple `/taches/{id}`. Indice : transformez le chemin de route en expression régulière (`{id}` devient `([^/]+)`), et extrayez les valeurs capturées pour les passer au gestionnaire.

## Exercice 3 — Contrôleur + Vue séparés (moyen)

Créez un `ProduitController` avec une méthode `liste()` qui prépare un tableau de produits (en dur, pas de base de données nécessaire) et appelle `Vue::afficher('produits/liste', ['produits' => $produits])`. Créez le fichier de vue correspondant qui affiche les produits dans une liste HTML.

## Exercice 4 — Front controller complet (difficile)

Assemblez les exercices précédents : un seul `public/index.php` qui définit les routes, instancie les contrôleurs, et appelle `$routeur->distribuer(...)`. Testez avec `php -S localhost:8000 public/index.php` (notez le nom de fichier après le port : cela force TOUTES les requêtes, y compris pour des chemins inexistants comme fichiers, à passer par ce script).

## Exercice 5 — Middleware maison sur le routeur (difficile)

Ajoutez à `Routeur` la possibilité d'associer un ou plusieurs "middlewares" (de simples fonctions retournant `bool`) à une route, exécutés **avant** le gestionnaire. Si un middleware retourne `false`, la requête s'arrête (par exemple avec un code 403). Utilisez ceci pour protéger une route `/admin` avec un middleware `estConnecte(): bool`.

---

Comparez avec [solutions/](solutions/) une fois terminé.
