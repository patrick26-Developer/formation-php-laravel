# Commandes — Exercice 2

```bash
docker compose up -d

docker compose exec mysql mysql -uroot -psecret -e \
  "USE test_persistance; CREATE TABLE test (id INT); INSERT INTO test VALUES (1);"

docker compose down
# SANS -v : le volume nommé "donnees_mysql" survit à la suppression des conteneurs.

docker compose up -d
docker compose exec mysql mysql -uroot -psecret -e "SELECT * FROM test_persistance.test;"
# La ligne insérée avant "docker compose down" est toujours là :
# preuve que le volume nommé a bien persisté les données, indépendamment
# du cycle de vie du conteneur mysql lui-même.
```
