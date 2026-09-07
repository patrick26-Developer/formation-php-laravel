# Solutions — 11.5 Monitoring et gestion des logs

## Exercice 1

```php
public function store(StoreAnnonceRequest $request): RedirectResponse
{
    $data = $request->validated();
    $data['user_id'] = $request->user()->id;
    $annonce = Annonce::create($data);

    logger()->info('Nouvelle annonce créée', [
        'user_id' => $request->user()->id,
        'annonce_id' => $annonce->id,
    ]);

    return redirect()->route('annonces.show', $annonce);
}
```

## Exercice 2

```php
// config/logging.php
'channels' => [
    'stack' => ['driver' => 'stack', 'channels' => ['single', 'daily']],
    'single' => ['driver' => 'single', 'path' => storage_path('logs/laravel.log')],
    'daily' => ['driver' => 'daily', 'path' => storage_path('logs/laravel.log'), 'days' => 14],
],
```
```bash
# .env
LOG_CHANNEL=stack
```
Après un `logger()->info('test')`, le message apparaît dans
`laravel.log` ET dans `laravel-2026-09-06.log` (fichier journalier).

## Exercice 3

```php
'critique' => [
    'driver' => 'single',
    'path' => storage_path('logs/critique.log'),
    'level' => 'error',
],
```
```php
logger('critique')->debug('ignoré');
logger('critique')->info('ignoré');
logger('critique')->error('apparaît dans critique.log');
```
Seul le message `error` apparaît dans `critique.log` : `debug` et `info`
sont en dessous du seuil configuré.

## Exercice 4

```php
// routes/web.php ou config Laravel 11+
use Illuminate\Support\Facades\DB;

Route::get('/up', function () {
    try {
        DB::connection()->getPdo();
        return response('OK', 200);
    } catch (\Throwable $e) {
        return response('Base de données injoignable', 503);
    }
});
```
Avec un mauvais `DB_PASSWORD` dans `.env` : `/up` retourne bien 503,
signalant clairement le problème à tout système de supervision externe.

## Exercice 5

```markdown
# POSTMORTEM.md — Notifications non envoyées pendant 2h

## Constat
14h32 : plusieurs utilisateurs signalent ne pas recevoir les notifications
de nouveaux messages sur leurs annonces. Aucune alerte automatique n'avait
été déclenchée (absence de healthcheck sur le worker lui-même).

## Diagnostic
`supervisorctl status` révèle que `laravel-worker:laravel-worker_00` est
en état FATAL depuis 12h41 (2h51 plus tôt) : le processus avait crashé
suite à une erreur mémoire (PHP Fatal error: Allowed memory size exhausted)
sur un Job traitant un lot anormalement volumineux, et Supervisor avait
atteint sa limite de tentatives de relance automatique (startretries).

## Contention
Relance manuelle immédiate : `supervisorctl start laravel-worker:*`.
Les jobs accumulés dans la table `jobs` (driver database) ont commencé à
être traités immédiatement après.

## Correction
- Augmentation de la limite mémoire PHP pour les workers spécifiquement
  (`memory_limit` plus élevé que pour le serveur web).
- `startretries` de Supervisor augmenté, ET ajout d'une alerte Slack
  dédiée sur le canal `critical` si un worker reste en état FATAL.
- Ajout d'un test reproduisant un Job avec un jeu de données volumineux,
  vérifiant qu'il se traite sans dépassement mémoire.

## Documentation
Ce post-mortem est partagé avec l'équipe. Action de suivi : ajouter un
healthcheck spécifique au worker (pas seulement à l'application web),
absent jusqu'ici et identifié comme la cause du délai de détection de 2h.
```
