# Exercices — 11.4 Déploiement en production

## Exercice 1 — Comparer les options d'hébergement (facile)

Pour chacun de ces projets, choisissez l'option d'hébergement du cours la plus adaptée et justifiez en une phrase : (a) le mini-projet du niveau 06 pour votre portfolio personnel, (b) une startup avec trafic imprévisible qui double parfois du jour au lendemain, (c) une agence qui gère 15 sites clients Laravel similaires.

## Exercice 2 — Configurer Supervisor (facile)

Sur une VM/conteneur avec Laravel installé, configurez Supervisor pour maintenir 2 workers de queue actifs. Tuez manuellement un processus worker (`kill -9`) et vérifiez qu'il redémarre automatiquement.

## Exercice 3 — Simuler un déploiement zéro-downtime (moyen)

Avec deux versions d'un conteneur Docker (v1 affichant "Version 1", v2 affichant "Version 2"), configurez Nginx pour basculer instantanément d'une version à l'autre en changeant sa configuration `upstream` puis en rechargeant Nginx (`nginx -s reload`, sans redémarrage complet). Vérifiez qu'aucune requête n'échoue pendant la bascule.

## Exercice 4 — Découper une migration destructive (moyen)

Simulez le renommage d'une colonne `nom` en `nom_complet` sur `users` de façon zéro-downtime : (1) ajoutez `nom_complet` sans retirer `nom`, dupliquez la valeur ; (2) déployez du code lisant `nom_complet` ; (3) seulement dans un déploiement ultérieur, supprimez `nom`. Documentez ces 3 étapes dans un fichier `MIGRATION-SANS-COUPURE.md`.

## Exercice 5 — Pipeline de déploiement complet (difficile)

Étendez le workflow CD de l'exercice 5 du module 11.3 avec un job `deployer` utilisant `appleboy/ssh-action`. Configurez les secrets nécessaires (utilisez une VM de test si possible). Vérifiez qu'un push sur `main` déclenche automatiquement build → push de l'image → déploiement → migrations → `optimize`, sans intervention manuelle.

---

Voir [solutions/README.md](solutions/README.md) pour le corrigé.
