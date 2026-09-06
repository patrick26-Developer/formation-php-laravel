# Solutions — 06.1 Installation de Laravel et Artisan

## Exercice 1

```bash
composer create-project laravel/laravel exercice-laravel
cd exercice-laravel
php artisan serve
```
`routes/web.php` contient une route unique par défaut (`/` → une vue de bienvenue). `bootstrap/app.php` retourne une instance configurée de l'application, avec des sections commentées pour ajouter routes, middlewares et gestion des exceptions.

## Exercice 2

```bash
php artisan tinker
>>> echo config('app.name');
Laravel
>>> echo now();
2026-09-06 14:32:10
>>> exit
```

## Exercice 3

```bash
php artisan make:model Produit -m -c
```
Crée `app/Models/Produit.php`, `app/Http/Controllers/ProduitController.php`, et `database/migrations/xxxx_xx_xx_create_produits_table.php`. Une seule commande couvre les trois fichiers liés à cette ressource.

## Exercice 4

```php
// routes/web.php
Route::get('/bonjour', function () {
    return 'Bonjour depuis ma route !';
});
```
```bash
php artisan route:list
# GET|HEAD  bonjour ................................
```

## Exercice 5

```bash
# .env
APP_NAME="Mon Application Modifiée"
```
```bash
php artisan config:clear
php artisan tinker
>>> echo config('app.name');
Mon Application Modifiée
```

Explication : en développement, Laravel lit `.env` à chaque requête (pas de cache actif par défaut), donc un changement devrait déjà être visible sans `config:clear`. **Mais** si `php artisan config:cache` a déjà été exécuté une fois (typiquement fait en production pour la performance), Laravel lit alors un fichier de cache figé (`bootstrap/cache/config.php`) plutôt que `.env` — `config:clear` supprime ce cache et force une relecture fraîche. C'est une source de confusion très fréquente chez les débutants Laravel : "j'ai changé mon `.env` mais rien ne se passe" est presque toujours résolu par `php artisan config:clear`.
