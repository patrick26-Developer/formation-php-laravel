# Commands — Exercise 4

```bash
cp .env.example .env
# Adjust .env if needed (different password, etc.)

docker compose up -d --build
```

Docker Compose automatically reads the `.env` file located next to
`docker-compose.yml`, and replaces `${DB_DATABASE}`/`${DB_PASSWORD}`
with their values before starting the containers — verifiable with:

```bash
docker compose config
# Shows the final docker-compose.yml, WITH the variables already substituted.
```
