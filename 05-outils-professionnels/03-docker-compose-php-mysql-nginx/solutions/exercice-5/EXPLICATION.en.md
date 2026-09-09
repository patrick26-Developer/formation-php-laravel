# Explanation — Exercise 5

`healthcheck` on the `mysql` service periodically runs (`interval: 5s`)
the `mysqladmin ping` command **inside** the container: if it responds
successfully, Docker marks the container as `healthy`. Before that
(while MySQL initializes its data files, creates the database, etc.),
the container stays `starting`, even though it's technically already
"started" in the sense of a simple `depends_on`.

`depends_on: mysql: condition: service_healthy` on the `php` service
specifically waits for this status to become `healthy` before starting
the `php` container — unlike a plain `depends_on: - mysql`
(seen in earlier exercises), which only guarantees the container
startup ORDER, not that the service inside is actually operational.

Verification:
```bash
docker compose up -d
docker compose ps
# The mysql service's STATUS column should show "(healthy)" once ready,
# and the php service should only start at that point.
```

Without this mechanism, a "cold" deployment (all containers created at
once, empty database) would often cause a PHP → MySQL connection error
in the very first seconds, while MySQL is still actually finishing its
initialization.
