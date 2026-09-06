# Exécution

## Lancer les tests

```bash
php artisan test --filter=Api
```

## Lancer l'application

```bash
php artisan serve
```

## Explorer la documentation interactive

Ouvrez `http://localhost:8000/api/documentation` : chaque endpoint peut être testé directement depuis le navigateur.

## Tester l'API avec curl

```bash
# Lister les annonces (public)
curl http://localhost:8000/api/v1/annonces

# Se connecter
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"demo@example.com","password":"password"}'
# {"token":"1|XXXX...","token_type":"Bearer"}

# Récupérer son profil
curl http://localhost:8000/api/v1/me -H "Authorization: Bearer 1|XXXX..."

# Créer une annonce (authentifié)
curl -X POST http://localhost:8000/api/v1/annonces \
  -H "Authorization: Bearer 1|XXXX..." \
  -H "Content-Type: application/json" \
  -d '{"categorie_id":1,"titre":"Vélo","description":"Bon état","prix":150}'

# Contacter un vendeur (public)
curl -X POST http://localhost:8000/api/v1/annonces/1/messages \
  -H "Content-Type: application/json" \
  -d '{"expediteur_nom":"Alice","expediteur_email":"alice@example.com","contenu":"Toujours disponible ?"}'
```

## Vérifier le rate limiting

```bash
for i in {1..8}; do
  curl -s -o /dev/null -w "%{http_code}\n" -X POST http://localhost:8000/api/v1/login \
    -d '{"email":"x@x.com","password":"faux"}' -H "Content-Type: application/json"
done
# Les tentatives 6, 7, 8 retournent 429 (limite "connexion" : 5/minute)
```

## Vérifier la réutilisation de la Policy

Créez deux utilisateurs, obtenez un jeton pour chacun. Tentez de supprimer l'annonce de l'utilisateur A avec le jeton de l'utilisateur B (`DELETE /api/v1/annonces/{id}`) : réponse **403**, exactement le même comportement que sur l'interface web du niveau 07, car `AnnoncePolicy` est partagée sans modification.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
