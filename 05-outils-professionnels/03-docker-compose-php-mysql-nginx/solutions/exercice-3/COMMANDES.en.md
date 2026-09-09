# Commands — Exercise 3

```bash
# 1. Copy mini-project 02's content (public/, src/, config.php...) into ./app/
mkdir app
cp -r /path/to/projet-mini-02-gestion-taches-crud-pdo/* app/

# 2. Adapt app/config.php to point to the "mysql" host (the service name),
#    not "127.0.0.1":
#    'db_host' => 'mysql',

# 3. Start the stack
docker compose up -d --build

# 4. Create the schema and demo user INSIDE the mysql/php container
docker compose exec mysql mysql -uroot -psecret gestion_taches < app/sql/schema.sql
docker compose exec php php src/seed.php

# 5. Open http://localhost:8080/connexion.php
```

Note: `app/config.php` must use `db_host => 'mysql'` and not
`127.0.0.1`, because from inside the `php` container, `127.0.0.1` refers
to the container itself, not the `mysql` service — this is exactly the
point of the service name resolution covered in the lesson.
