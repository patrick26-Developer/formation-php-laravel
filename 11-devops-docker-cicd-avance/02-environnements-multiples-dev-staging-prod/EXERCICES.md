# Exercices — 11.2 Environnements multiples

## Exercice 1 — Fichiers .env séparés (facile)

Créez `.env.example`, `.env` (local, `APP_DEBUG=true`), et documentez dans un `ENVIRONNEMENTS.md` les différences attendues pour staging et production (au minimum `APP_ENV`, `APP_DEBUG`).

## Exercice 2 — Override de développement (facile)

Créez `docker-compose.override.yml` montant le code source en volume. Modifiez un fichier PHP local et vérifiez que le changement est visible sans reconstruire l'image.

## Exercice 3 — Compose de production (moyen)

Créez `docker-compose.prod.yml` avec `restart: unless-stopped` et sans volume de code. Lancez avec `docker compose -f docker-compose.yml -f docker-compose.prod.yml up -d` et vérifiez qu'un `docker kill` du conteneur `app` provoque bien son redémarrage automatique.

## Exercice 4 — Simuler un déploiement de migration (moyen)

Sur une base de "staging" avec des données de test, exécutez `php artisan migrate --force` après avoir ajouté une nouvelle migration. Vérifiez que les données existantes sont préservées (contrairement à `migrate:fresh`).

## Exercice 5 — Détecter une fuite de configuration (difficile)

Avec `APP_DEBUG=true` sur une instance simulant la production, provoquez une erreur volontaire (division par zéro, appel de méthode inexistante) et observez les informations exposées dans la réponse HTTP (chemins de fichiers, requêtes SQL éventuelles). Corrigez avec `APP_DEBUG=false` et comparez la réponse (page d'erreur générique). Documentez dans un court rapport (`AUDIT.md`) ce qui aurait pu être exposé à un attaquant.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
