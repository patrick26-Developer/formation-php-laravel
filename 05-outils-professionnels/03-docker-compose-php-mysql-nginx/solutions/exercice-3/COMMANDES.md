# Commandes — Exercice 3

```bash
# 1. Copier le contenu du mini-projet 02 (public/, src/, config.php...) dans ./app/
mkdir app
cp -r /chemin/vers/projet-mini-02-gestion-taches-crud-pdo/* app/

# 2. Adapter app/config.php pour pointer vers l'hôte "mysql" (le nom du service),
#    pas "127.0.0.1" :
#    'db_host' => 'mysql',

# 3. Démarrer la stack
docker compose up -d --build

# 4. Créer le schéma et l'utilisateur de démonstration DANS le conteneur mysql/php
docker compose exec mysql mysql -uroot -psecret gestion_taches < app/sql/schema.sql
docker compose exec php php src/seed.php

# 5. Ouvrir http://localhost:8080/connexion.php
```

Remarque : `app/config.php` doit utiliser `db_host => 'mysql'` et non
`127.0.0.1`, car depuis le conteneur `php`, `127.0.0.1` désigne le
conteneur lui-même, pas le service `mysql` — c'est tout l'intérêt de la
résolution de noms de service évoquée dans le cours.
