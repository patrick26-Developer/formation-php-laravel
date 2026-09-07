# Exécution

## Lancer les tests

```bash
php artisan test --filter=AnalyserLogsCommandTest
```

## Générer des logs de test puis analyser

```bash
php artisan tinker
>>> logger()->error('Erreur de démonstration 1');
>>> logger()->error('Erreur de démonstration 2');
>>> logger()->warning('Avertissement de démonstration');
>>> logger()->info('Information de démonstration');
>>> exit
```

```bash
php artisan logs:analyser
```
```
Analyse de : /chemin/vers/storage/logs/laravel.log

+---------+-------------+
| Niveau  | Occurrences |
+---------+-------------+
| ERROR   | 2           |
| WARNING | 1           |
| INFO    | 1           |
+---------+-------------+

Total : 4 entrées.
```

## Filtrer par niveau

```bash
php artisan logs:analyser --niveau=error
```
```
+--------+-------------+
| Niveau | Occurrences |
+--------+-------------+
| ERROR  | 2           |
+--------+-------------+

Total : 2 entrées.
```

## Analyser un fichier spécifique

```bash
php artisan logs:analyser storage/logs/laravel-2026-09-01.log
```

## Vérifier le code de sortie (utile en script/CI)

```bash
php artisan logs:analyser fichier-inexistant.log; echo "Code de sortie : $?"
# Code de sortie : 1
```

**Voir aussi :** [JOURNAL.md](JOURNAL.md) pour la démarche de construction complète.
