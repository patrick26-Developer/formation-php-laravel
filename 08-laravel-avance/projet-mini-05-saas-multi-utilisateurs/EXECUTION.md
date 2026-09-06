# Exécution

## Lancer la suite de tests (à faire en premier)

```bash
php artisan test
```

`IsolationTenantTest` est le test le plus important de ce projet : il
prouve, de façon reproductible, qu'un utilisateur d'un tenant ne peut ni
lister ni afficher les projets d'un autre tenant. C'est la meilleure porte
d'entrée pour comprendre ce mini-projet avant même de lancer l'interface.

## Lancer l'application

```bash
php artisan serve
```

Dans un second terminal, démarrez le worker pour que les rapports en arrière-plan soient traités :
```bash
php artisan queue:work
```

## Utiliser l'application

1. Récupérez un email d'utilisateur : `php artisan tinker` puis `\App\Models\User::first()->email` (mot de passe : `password`).
2. Connectez-vous, observez le tableau de bord : projets actifs / total, filtré à votre seul tenant.
3. Créez un projet, cliquez sur "Générer le rapport hebdomadaire".
4. Consultez `storage/logs/laravel.log` (avec le worker actif) : le rapport apparaît quelques instants après, traité en arrière-plan.

## Vérifier l'isolation manuellement

Connectez-vous avec un utilisateur du tenant "Acme Corp", notez l'ID d'un de ses projets dans l'URL. Déconnectez-vous, connectez-vous avec un utilisateur de "Globex", et tentez d'accéder directement à `/projects/{cet-id}` : Laravel doit répondre **404** (le scope global rend le projet introuvable pour ce tenant, avant même toute vérification de Policy).

## Vérifier le cache

Avec `DB::listen()` actif (module 07.1), rechargez le tableau de bord plusieurs fois : la requête de comptage des statistiques ne doit apparaître qu'une fois toutes les 10 minutes (durée du cache), pas à chaque chargement de page.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
