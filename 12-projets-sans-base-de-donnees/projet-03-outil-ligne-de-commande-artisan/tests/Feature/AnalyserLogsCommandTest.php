<?php

declare(strict_types=1);

test('la commande signale une erreur si le fichier est introuvable', function () {
    $this->artisan('logs:analyser', ['chemin' => '/chemin/inexistant.log'])
        ->assertExitCode(1);
});

test('la commande compte correctement les niveaux de log', function () {
    $cheminTemporaire = sys_get_temp_dir() . '/test_' . uniqid() . '.log';
    file_put_contents($cheminTemporaire, implode("\n", [
        '[2026-09-06 10:00:00] local.ERROR: Une erreur',
        '[2026-09-06 10:01:00] local.ERROR: Une autre erreur',
        '[2026-09-06 10:02:00] local.INFO: Information',
    ]));

    $this->artisan('logs:analyser', ['chemin' => $cheminTemporaire])
        ->expectsOutputToContain('ERROR')
        ->expectsOutputToContain('2')
        ->assertExitCode(0);

    unlink($cheminTemporaire);
});

test('l\'option --niveau filtre le résultat', function () {
    $cheminTemporaire = sys_get_temp_dir() . '/test_' . uniqid() . '.log';
    file_put_contents($cheminTemporaire, implode("\n", [
        '[2026-09-06 10:00:00] local.ERROR: Une erreur',
        '[2026-09-06 10:01:00] local.WARNING: Un avertissement',
    ]));

    $this->artisan('logs:analyser', ['chemin' => $cheminTemporaire, '--niveau' => 'error'])
        ->expectsOutputToContain('ERROR')
        ->doesntExpectOutputToContain('WARNING')
        ->assertExitCode(0);

    unlink($cheminTemporaire);
});
