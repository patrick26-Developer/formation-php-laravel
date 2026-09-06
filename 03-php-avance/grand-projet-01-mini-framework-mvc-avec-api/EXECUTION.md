# Exécution

## Lancer les tests automatisés

```bash
./vendor/bin/phpunit
```

Ces tests utilisent SQLite en mémoire (voir [JOURNAL.md](JOURNAL.md)) : ils s'exécutent en une fraction de seconde, sans nécessiter la base MySQL configurée à l'étape précédente.

## Lancer l'application (web + API)

Depuis la racine du projet :

```bash
php -S localhost:8000 -t public public/index.php
```

> 📌 `-t public` définit `public/` comme racine du serveur ; `public/index.php` en second argument force **toutes** les requêtes (même celles ne correspondant à aucun fichier réel) à passer par le front controller — indispensable pour que des routes comme `/taches/creer` fonctionnent.

## Utiliser l'interface web

Ouvrez `http://localhost:8000/taches` : liste des tâches avec tri (cliquez sur les en-têtes) et recherche. Créez une tâche via `http://localhost:8000/taches/creer`.

## Utiliser l'API JSON

```bash
# Lister les tâches
curl http://localhost:8000/api/taches

# Créer une tâche
curl -X POST http://localhost:8000/api/taches \
  -H "Content-Type: application/json" \
  -d '{"titre":"Apprendre les API REST","description":"Module 03.4"}'

# Récupérer une tâche précise
curl http://localhost:8000/api/taches/1

# Modifier une tâche (marquer comme terminée)
curl -X PUT http://localhost:8000/api/taches/1 \
  -H "Content-Type: application/json" \
  -d '{"terminee": true}'

# Supprimer une tâche
curl -X DELETE http://localhost:8000/api/taches/1

# Tester le cas d'erreur : tâche inexistante
curl -i http://localhost:8000/api/taches/9999   # -> 404
```

## Vérifier la cohérence Web/API

Créez une tâche via l'interface web (`/taches/creer`), puis récupérez-la immédiatement via `curl http://localhost:8000/api/taches` : elle doit apparaître, preuve que les deux interfaces partagent bien le même `TacheRepository` et donc la même base de données.
