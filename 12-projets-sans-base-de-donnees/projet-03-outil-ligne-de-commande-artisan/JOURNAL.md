# Journal de construction

## Étape 1 — Une commande Artisan qui ne touche jamais Eloquent

Ce projet illustre volontairement qu'Artisan n'implique pas systématiquement de base de données : `AnalyserLogsCommand` ne référence aucun modèle, aucune migration. C'est un rappel utile après plusieurs niveaux (06 à 10) où Artisan était presque toujours associé à `make:model`/`migrate` — sa vraie nature est celle d'un framework CLI généraliste, hérité du composant Symfony Console.

## Étape 2 — La signature, équivalent déclaratif du parsing de `$argv`

```
{chemin? : Chemin du fichier de log}
{--niveau= : Ne compter qu'un niveau précis}
```
Comparez avec le [module 01.9](../../01-php-fondamentaux/09-gestion-erreurs-debutant/README.md) et l'usage de `$argv` dans les projets CLI précédents (module 12, projets 1 et 2) : là où un script PHP natif doit valider manuellement la présence de chaque argument (`if ($argv[1] === null) { ... }`), Artisan parse, valide le type, et documente automatiquement (`?` = optionnel, `--niveau=` = option avec valeur) — visible directement via `php artisan help logs:analyser`.

## Étape 3 — Une détection de niveau simple mais explicite

`compterParNiveau()` cherche la sous-chaîne `.ERROR:` etc. dans chaque ligne, en s'appuyant sur le format standard des logs Laravel (`[date] environnement.NIVEAU: message`). Ce n'est pas un parseur générique de tout format de log imaginable — un choix assumé : ce projet cible spécifiquement les logs Laravel, pas un outil universel, cohérent avec le principe YAGNI déjà rencontré au [module 08.5](../../08-laravel-avance/05-architecture-modulaire/README.md).

## Étape 4 — Retourner des codes de sortie exploitables

`self::SUCCESS` (0) et `self::FAILURE` (1) rendent cette commande utilisable dans un script shell ou une étape de pipeline CI/CD (module 11.3) : `php artisan logs:analyser --niveau=critical; if [ $? -ne 0 ]; then alert; fi` devient possible sans avoir à parser la sortie texte de la commande.

## Étape 5 — Tester une commande Artisan comme une route

`AnalyserLogsCommandTest` utilise `$this->artisan()`, l'équivalent pour les commandes de `$this->get()`/`$this->post()` pour les routes HTTP (module 08.3) : mêmes principes de test Feature (piloter le comportement observable, pas les détails internes), adaptés à une interface CLI plutôt que web.

## Pour aller plus loin (hors scope de ce projet)

Aucune détection de "pic anormal" (comparaison à une moyenne historique) n'est implémentée — un futur ajout naturel combinerait ce projet avec un envoi de notification (module 07.7) en cas de seuil dépassé.
