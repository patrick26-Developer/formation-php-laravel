# Solutions — 11.2 Environnements multiples

## Exercice 1

```markdown
# ENVIRONNEMENTS.md

| Variable | Local | Staging | Production |
|---|---|---|---|
| APP_ENV | local | staging | production |
| APP_DEBUG | true | false | false |
| DB_DATABASE | app_local | app_staging | app_production |
| MAIL_MAILER | log | smtp (boîte de test) | smtp (réel) |
```

## Exercice 2

```yaml
# docker-compose.override.yml
services:
  app:
    volumes:
      - .:/var/www/html
```
Après `docker compose up`, modifier `routes/web.php` localement change
immédiatement le comportement de l'application servie, sans `docker build`.

## Exercice 3

```yaml
# docker-compose.prod.yml
services:
  app:
    restart: unless-stopped
```
```bash
docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d
docker kill $(docker compose ps -q app)
docker compose ps  # le conteneur "app" est déjà repassé en "Up" quelques secondes après
```

## Exercice 4

```bash
php artisan make:migration add_note_moyenne_to_produits_table
# ... colonne ajoutée dans up() ...
php artisan migrate --force
```
Les enregistrements `produits` existants restent intacts, seule la
nouvelle colonne apparaît (valeur par défaut appliquée automatiquement).

## Exercice 5

```markdown
# AUDIT.md

Avec APP_DEBUG=true : une erreur (ex: DivisionByZeroError) affiche la
stack trace COMPLÈTE dans le navigateur, incluant :
- Le chemin absolu des fichiers du serveur (ex: /var/www/html/app/...)
- La requête SQL exacte en cours si l'erreur venait d'Eloquent
- Les valeurs de certaines variables locales au moment de l'erreur
- La version de Laravel et des packages installés

Un attaquant pourrait exploiter ces informations pour cartographier la
structure de l'application, identifier des versions de dépendances
vulnérables, ou déduire le schéma de base de données.

Avec APP_DEBUG=false : une simple page "500 | Server Error" générique,
sans aucun détail technique. L'erreur reste journalisée en interne
(storage/logs/laravel.log) pour l'équipe technique, mais invisible au
client HTTP.

Conclusion : APP_DEBUG=false est non négociable en production.
```
