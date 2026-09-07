# Exécution

## Consulter la météo d'une ville

```bash
php bin/meteo.php Paris 48.8566 2.3522
```
```
Météo actuelle à Paris :
  Température : 18.5°C
  Vent : 12.3 km/h
  Relevé à : 2026-09-06T14:00
```

Quelques coordonnées pour tester :
```bash
php bin/meteo.php Lyon 45.7640 4.8357
php bin/meteo.php Marseille 43.2965 5.3698
```

## Observer le cache en action

Exécutez la même commande deux fois de suite rapidement : la seconde exécution est **instantanée** (pas d'appel réseau), le fichier `cache/<hash>.json` en fait foi (`cat cache/*.json`). Attendez plus de 15 minutes (ou modifiez temporairement `DUREE_CACHE_SECONDES` à `5` dans `MeteoClient.php` pour tester plus vite) et l'appel suivant recontacte réellement l'API.

## Lancer les tests (aucun appel réseau réel)

```bash
composer test
```

Les trois tests s'exécutent en quelques millisecondes, sans jamais contacter `api.open-meteo.com` — grâce au `MockHandler` de Guzzle.

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
