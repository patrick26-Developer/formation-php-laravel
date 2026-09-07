<?php

declare(strict_types=1);

namespace App;

use App\Cache\FileCache;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Consomme l'API publique Open-Meteo (aucune clé d'API requise), avec
 * mise en cache locale de 15 minutes pour éviter d'interroger l'API
 * externe à chaque exécution — une bonne pratique tant pour la performance
 * que pour respecter les limites d'usage du service tiers.
 */
class MeteoClient
{
    private const DUREE_CACHE_SECONDES = 900; // 15 minutes

    public function __construct(
        private readonly Client $httpClient,
        private readonly FileCache $cache,
    ) {
    }

    /**
     * @return array{temperature: float, vent_kmh: float, heure: string}
     */
    public function meteoActuelle(float $latitude, float $longitude): array
    {
        $cle = "meteo:$latitude:$longitude";

        return $this->cache->remember($cle, self::DUREE_CACHE_SECONDES, function () use ($latitude, $longitude) {
            return $this->interrogerApi($latitude, $longitude);
        });
    }

    /**
     * @return array{temperature: float, vent_kmh: float, heure: string}
     */
    private function interrogerApi(float $latitude, float $longitude): array
    {
        try {
            $reponse = $this->httpClient->get('https://api.open-meteo.com/v1/forecast', [
                'query' => [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current_weather' => 'true',
                ],
                'timeout' => 5, // ne jamais laisser un appel externe bloquer indéfiniment
            ]);
        } catch (GuzzleException $e) {
            throw new \RuntimeException('Impossible de contacter le service météo : ' . $e->getMessage(), previous: $e);
        }

        $donnees = json_decode((string) $reponse->getBody(), true);

        if (!isset($donnees['current_weather'])) {
            throw new \RuntimeException('Réponse inattendue du service météo.');
        }

        return [
            'temperature' => (float) $donnees['current_weather']['temperature'],
            'vent_kmh' => (float) $donnees['current_weather']['windspeed'],
            'heure' => (string) $donnees['current_weather']['time'],
        ];
    }
}
