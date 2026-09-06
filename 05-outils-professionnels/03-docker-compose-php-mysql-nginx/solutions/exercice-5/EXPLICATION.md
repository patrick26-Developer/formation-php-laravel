# Explication — Exercice 5

`healthcheck` sur le service `mysql` exécute périodiquement (`interval: 5s`)
la commande `mysqladmin ping` **à l'intérieur** du conteneur : si elle
répond avec succès, Docker marque le conteneur comme `healthy`. Avant cela
(le temps que MySQL initialise ses fichiers de données, crée la base, etc.),
le conteneur reste `starting`, même s'il est techniquement déjà "démarré"
au sens de `depends_on` simple.

`depends_on: mysql: condition: service_healthy` sur le service `php`
attend spécifiquement que ce statut passe à `healthy` avant de démarrer
le conteneur `php` — contrairement à un simple `depends_on: - mysql`
(vu dans les exercices précédents), qui ne garantit que l'ORDRE de
démarrage des conteneurs, pas que le service à l'intérieur soit
réellement opérationnel.

Vérification :
```bash
docker compose up -d
docker compose ps
# La colonne STATUS du service mysql doit afficher "(healthy)" une fois prêt,
# et le service php ne doit démarrer qu'à ce moment-là.
```

Sans ce mécanisme, un déploiement "à froid" (tous les conteneurs créés en
même temps, base de données vide) provoquerait souvent une erreur de
connexion PHP → MySQL dans les toutes premières secondes, le temps que
MySQL termine réellement son initialisation.
