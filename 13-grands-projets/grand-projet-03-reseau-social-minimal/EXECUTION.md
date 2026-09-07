# Exécution

## Lancer les tests

```bash
php artisan test --filter=FeedTest
```

## Lancer l'application

```bash
php artisan serve
```

Connectez-vous avec un des comptes générés par le seeder (mot de passe `password`), puis parcourez `/fil-actualite` : publiez, likez, suivez d'autres comptes.

## Tester l'API

```bash
curl -X POST http://localhost:8000/api/login -d '{"email":"...","password":"password"}' -H "Content-Type: application/json"
curl http://localhost:8000/api/v1/fil-actualite -H "Authorization: Bearer <token>"
```
*(Note : l'endpoint `/api/login` est celui du [mini-projet du niveau 09](../../09-api-rest-laravel/projet-mini-06-api-rest-complete/README.md) — à ajouter si vous partez d'un projet vierge.)*

## Vérifier le fil d'actualité filtré

Créez trois comptes A, B, C. A suit B mais pas C. Publiez un post depuis chacun. Connecté en tant que A, `/fil-actualite` doit afficher les posts de A et B, jamais celui de C — exactement ce que vérifie `FeedTest`.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
