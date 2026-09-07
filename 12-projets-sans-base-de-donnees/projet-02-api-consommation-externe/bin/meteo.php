<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Cache\FileCache;
use App\MeteoClient;
use GuzzleHttp\Client;

// Usage : php bin/meteo.php Paris 48.8566 2.3522

[, $ville, $latitude, $longitude] = $argv + [null, null, null, null];

if ($ville === null || $latitude === null || $longitude === null) {
    fwrite(STDERR, "Usage : php bin/meteo.php <ville> <latitude> <longitude>\n");
    fwrite(STDERR, "Exemple : php bin/meteo.php Paris 48.8566 2.3522\n");
    exit(1);
}

$client = new MeteoClient(
    new Client(),
    new FileCache(__DIR__ . '/../cache'),
);

try {
    $meteo = $client->meteoActuelle((float) $latitude, (float) $longitude);

    echo "Météo actuelle à $ville :\n";
    echo "  Température : {$meteo['temperature']}°C\n";
    echo "  Vent : {$meteo['vent_kmh']} km/h\n";
    echo "  Relevé à : {$meteo['heure']}\n";
} catch (\RuntimeException $e) {
    fwrite(STDERR, 'Erreur : ' . $e->getMessage() . "\n");
    exit(1);
}
