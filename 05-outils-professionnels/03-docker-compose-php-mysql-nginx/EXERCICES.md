# Exercices — 05.3 Docker Compose : PHP + MySQL + Nginx

## Exercice 1 — Stack minimale (facile)

Écrivez un `docker-compose.yml` avec seulement deux services : `php` (basé sur `php:8.3-cli`, avec un volume montant votre dossier de code) et rien d'autre. Lancez-le et vérifiez `docker compose exec php php -v`.

## Exercice 2 — Ajouter MySQL avec persistance (facile)

Ajoutez un service `mysql` avec un volume nommé pour la persistance. Démarrez la stack, créez une table via `docker compose exec mysql mysql -uroot -psecret` (ou un client externe), arrêtez tout avec `docker compose down` (SANS `-v`), redémarrez, et vérifiez que la table existe toujours.

## Exercice 3 — Stack complète PHP-FPM + Nginx + MySQL (moyen)

Assemblez la stack complète du cours pour le [mini-projet Gestionnaire de tâches](../../02-php-intermediaire/projet-mini-02-gestion-taches-crud-pdo/README.md) : PHP-FPM, Nginx (avec la configuration adaptée au dossier `public/`), MySQL. Faites fonctionner l'application dans son intégralité via `http://localhost:8080`.

## Exercice 4 — Variables d'environnement (moyen)

Reprenez l'exercice 3 et extrayez tous les identifiants MySQL (nom de base, mot de passe root) dans un fichier `.env`, référencé dans `docker-compose.yml` avec `${VARIABLE}`. Vérifiez que tout fonctionne toujours après ce changement.

## Exercice 5 — Healthcheck et ordre de démarrage fiable (difficile)

`depends_on` seul ne garantit pas que MySQL est **prêt** à accepter des connexions, seulement que son conteneur a démarré. Ajoutez un `healthcheck` au service `mysql` (utilisant `mysqladmin ping`) et une condition `depends_on: mysql: condition: service_healthy` sur le service `php`, pour que PHP attende réellement que MySQL soit opérationnel avant de démarrer.

---

Comparez avec [solutions/](solutions/) une fois terminé.
