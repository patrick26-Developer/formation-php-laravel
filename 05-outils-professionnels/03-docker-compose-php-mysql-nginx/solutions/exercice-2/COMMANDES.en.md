# Commands — Exercise 2

```bash
docker compose up -d

docker compose exec mysql mysql -uroot -psecret -e \
  "USE test_persistance; CREATE TABLE test (id INT); INSERT INTO test VALUES (1);"

docker compose down
# WITHOUT -v: the named "donnees_mysql" volume survives the containers' removal.

docker compose up -d
docker compose exec mysql mysql -uroot -psecret -e "SELECT * FROM test_persistance.test;"
# The row inserted before "docker compose down" is still there:
# proof that the named volume correctly persisted the data, independently
# of the mysql container's own lifecycle.
```
