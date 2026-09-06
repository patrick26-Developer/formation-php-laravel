# Commandes — Exercice 4

```bash
# Depuis le dossier "public" du mini-projet 02, avec ce Dockerfile copié à la racine
docker build -t gestionnaire-taches .
docker run -p 8080:80 gestionnaire-taches
```

Ouvrez `http://localhost:8080/connexion.php`.

> Remarque : ce conteneur seul n'a pas accès à une base MySQL — il lui en
> faudrait une, accessible en réseau. C'est précisément ce que résout
> Docker Compose au module 05.3 : plusieurs conteneurs (PHP + MySQL + Nginx)
> qui communiquent entre eux sans configuration réseau manuelle.
