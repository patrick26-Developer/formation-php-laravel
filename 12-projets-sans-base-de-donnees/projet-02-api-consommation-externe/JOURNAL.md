# Journal de construction

## Étape 1 — Choisir une API sans clé d'authentification

Open-Meteo a été choisie délibérément : gratuite, sans inscription ni clé d'API à gérer (donc rien à mettre dans un `.env` ni à protéger, module 06.1), ce qui garde ce projet focalisé sur la consommation HTTP elle-même plutôt que sur la gestion de secrets.

## Étape 2 — `FileCache`, une version minimaliste de `Cache::remember()`

`FileCache::remember()` reproduit volontairement l'API de `Cache::remember()` (module 08.2) : même nom de méthode, même signature (clé, durée, callback). Ce choix n'est pas un hasard — un développeur venant de Laravel reconnaît immédiatement le pattern, et migrer ce code vers une vraie application Laravel plus tard ne demanderait qu'un remplacement d'implémentation, pas un changement de logique appelante.

## Étape 3 — `MeteoClient` ne connaît pas Guzzle directement dans sa logique métier

Le constructeur reçoit un `Client` Guzzle déjà construit (injection de dépendance, module 08.4), plutôt que d'en instancier un lui-même avec `new Client()`. C'est ce qui rend `MeteoClientTest` possible : les tests injectent un `Client` configuré avec un `MockHandler`, sans qu'aucune ligne de `MeteoClient` n'ait besoin d'être consciente qu'elle est testée.

## Étape 4 — Gérer les deux modes d'échec distinctement

Deux situations d'échec bien différentes sont capturées séparément : `GuzzleException` (le réseau a échoué — timeout, DNS, service injoignable) et une réponse HTTP 200 mais au contenu inattendu (`current_weather` absent — l'API a changé de format, ou renvoie une erreur dans un format non standard). Les deux sont traduites en `RuntimeException` avec un message explicite, plutôt que de laisser fuiter l'exception Guzzle brute jusqu'à l'utilisateur final de la CLI.

## Étape 5 — Tester le cache sans mocker le système de fichiers

`test_utilise_le_cache_sans_rappeler_lapi` prouve le comportement du cache d'une façon élégante : en ne fournissant **qu'une seule** réponse simulée au `MockHandler`. Si `MeteoClient` appelait l'API une seconde fois au lieu d'utiliser le cache, Guzzle lèverait une exception ("no more responses configured") — le test échouerait alors clairement, sans avoir eu besoin d'inspecter directement le contenu du fichier de cache.

## Pour aller plus loin (hors scope de ce projet)

Aucune gestion de plusieurs villes en une seule commande, ni d'historique des relevés (qui nécessiterait alors une base de données, sortant du périmètre volontaire de ce niveau).
