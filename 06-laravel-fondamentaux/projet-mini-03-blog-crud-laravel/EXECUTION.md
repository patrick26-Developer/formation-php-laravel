# Exécution

## Lancer l'application

```bash
php artisan serve
```

Ouvrez `http://localhost:8000` (redirige automatiquement vers `/articles`).

## Utiliser le blog

- **Parcourir les articles** : liste paginée (6 par page) des articles publiés.
- **Rechercher** : champ de recherche filtrant sur le titre.
- **Filtrer par catégorie** : menu déroulant.
- **Trier** : liens "Titre"/"Date" en haut de la liste, cliquables pour inverser l'ordre.
- **Consulter un article** : clic sur son titre, affiche le contenu complet et ses commentaires.
- **Commenter** : formulaire en bas de la page d'un article.
- **Créer/modifier/supprimer un article** : liens "+ Nouvel article" (menu) et "Modifier"/"Supprimer" (page d'un article).
- **Gérer les catégories** : page "Catégories" du menu — création et suppression (une suppression retire aussi tous les articles liés, `cascadeOnDelete`).

## Vérifier l'eager loading (absence de problème N+1)

Activez la barre de débogage Laravel (`composer require --dev barryvdh/laravel-debugbar`) ou consultez `storage/logs/laravel.log` avec le driver de requêtes en mode `log` : la page `/articles` ne doit exécuter **qu'une seule requête** pour charger les articles avec leurs catégories (`with('categorie')`), pas une requête par article.

## Tester la validation

Essayez de créer un article avec un `slug` déjà utilisé : le formulaire doit se réafficher avec l'erreur `alpha_dash`/`unique` sous le bon champ, et vos autres saisies (titre, contenu) doivent rester pré-remplies (`old()`).

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
