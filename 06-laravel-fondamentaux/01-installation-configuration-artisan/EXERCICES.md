# Exercices — 06.1 Installation de Laravel et Artisan

## Exercice 1 — Première installation (facile)

Installez un nouveau projet Laravel. Lancez `php artisan serve` et confirmez la page d'accueil. Explorez `routes/web.php` et `bootstrap/app.php`.

## Exercice 2 — Explorer avec Tinker (facile)

Lancez `php artisan tinker`. Exécutez `echo config('app.name');`, puis `echo now();` (affiche la date/heure actuelle via la classe Carbon, incluse nativement). Quittez avec `exit`.

## Exercice 3 — Générer un contrôleur et un modèle (moyen)

Générez un contrôleur `ProduitController` et un modèle `Produit` avec sa migration en une seule commande (`make:model Produit -m -c`). Observez les fichiers créés et leur emplacement.

## Exercice 4 — Explorer les routes (moyen)

Ajoutez une route simple dans `routes/web.php` retournant une chaîne de caractères. Lancez `php artisan route:list` et repérez votre nouvelle route dans la liste.

## Exercice 5 — Configuration d'environnement (difficile)

Changez `APP_NAME` dans `.env`, exécutez `php artisan config:clear`, puis vérifiez via Tinker que `config('app.name')` reflète la nouvelle valeur. Expliquez en commentaire pourquoi un simple changement de `.env` peut ne pas être pris en compte sans cette commande (indice : le cache de configuration, activé par `php artisan config:cache` en production).

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé commenté de chaque exercice.
