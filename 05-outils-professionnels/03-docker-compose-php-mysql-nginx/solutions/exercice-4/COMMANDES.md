# Commandes — Exercice 4

```bash
cp .env.example .env
# Ajuster .env si besoin (mot de passe différent, etc.)

docker compose up -d --build
```

Docker Compose lit automatiquement le fichier `.env` situé au même niveau
que `docker-compose.yml`, et remplace `${DB_DATABASE}`/`${DB_PASSWORD}`
par leurs valeurs avant de démarrer les conteneurs — vérifiable avec :

```bash
docker compose config
# Affiche le docker-compose.yml final, AVEC les variables déjà substituées.
```
