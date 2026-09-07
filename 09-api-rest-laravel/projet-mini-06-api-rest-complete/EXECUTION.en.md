# Running the Application

## Run the tests

```bash
php artisan test --filter=Api
```

## Launch the application

```bash
php artisan serve
```

## Explore the interactive documentation

Open `http://localhost:8000/api/documentation`: every endpoint can be tested directly from the browser.

## Test the API with curl

```bash
# List listings (public)
curl http://localhost:8000/api/v1/annonces

# Log in
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"demo@example.com","password":"password"}'
# {"token":"1|XXXX...","token_type":"Bearer"}

# Get your profile
curl http://localhost:8000/api/v1/me -H "Authorization: Bearer 1|XXXX..."

# Create a listing (authenticated)
curl -X POST http://localhost:8000/api/v1/annonces \
  -H "Authorization: Bearer 1|XXXX..." \
  -H "Content-Type: application/json" \
  -d '{"categorie_id":1,"titre":"Bike","description":"Good condition","prix":150}'

# Contact a seller (public)
curl -X POST http://localhost:8000/api/v1/annonces/1/messages \
  -H "Content-Type: application/json" \
  -d '{"expediteur_nom":"Alice","expediteur_email":"alice@example.com","contenu":"Still available?"}'
```

## Verifying rate limiting

```bash
for i in {1..8}; do
  curl -s -o /dev/null -w "%{http_code}\n" -X POST http://localhost:8000/api/v1/login \
    -d '{"email":"x@x.com","password":"wrong"}' -H "Content-Type: application/json"
done
# Attempts 6, 7, 8 return 429 ("connexion" limit: 5/minute)
```

## Verifying Policy reuse

Create two users, get a token for each. Try to delete user A's listing using user B's token (`DELETE /api/v1/annonces/{id}`): response **403**, exactly the same behavior as on the level 07 web interface, because `AnnoncePolicy` is shared without modification.

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
