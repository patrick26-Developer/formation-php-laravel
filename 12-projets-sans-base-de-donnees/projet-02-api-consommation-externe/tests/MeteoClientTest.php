<?php

declare(strict_types=1);

namespace App\Tests;

use App\Cache\FileCache;
use App\MeteoClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

final class MeteoClientTest extends TestCase
{
    private string $dossierCacheTemporaire;

    protected function setUp(): void
    {
        $this->dossierCacheTemporaire = sys_get_temp_dir() . '/cache_test_' . uniqid();
    }

    protected function tearDown(): void
    {
        array_map('unlink', glob($this->dossierCacheTemporaire . '/*') ?: []);
        if (is_dir($this->dossierCacheTemporaire)) {
            rmdir($this->dossierCacheTemporaire);
        }
    }

    private function client(array $reponsesSimulees): MeteoClient
    {
        // MockHandler : simule les réponses HTTP SANS appel réseau réel
        // (rappel du module 03.3 : isoler une classe de ses dépendances externes).
        $mock = new MockHandler($reponsesSimulees);
        $handlerStack = HandlerStack::create($mock);
        $httpClient = new Client(['handler' => $handlerStack]);

        return new MeteoClient($httpClient, new FileCache($this->dossierCacheTemporaire));
    }

    public function test_retourne_les_donnees_meteo_de_lapi(): void
    {
        $client = $this->client([
            new Response(200, [], json_encode([
                'current_weather' => ['temperature' => 18.5, 'windspeed' => 12.0, 'time' => '2026-09-06T14:00'],
            ])),
        ]);

        $meteo = $client->meteoActuelle(48.8566, 2.3522);

        $this->assertSame(18.5, $meteo['temperature']);
        $this->assertSame(12.0, $meteo['vent_kmh']);
    }

    public function test_utilise_le_cache_sans_rappeler_lapi(): void
    {
        $client = $this->client([
            new Response(200, [], json_encode([
                'current_weather' => ['temperature' => 20.0, 'windspeed' => 5.0, 'time' => '2026-09-06T14:00'],
            ])),
            // Une SEULE réponse simulée : si le client rappelait l'API une
            // seconde fois, MockHandler lèverait une exception "vide".
        ]);

        $client->meteoActuelle(48.8566, 2.3522);
        $meteoDepuisCache = $client->meteoActuelle(48.8566, 2.3522);

        $this->assertSame(20.0, $meteoDepuisCache['temperature']);
    }

    public function test_leve_une_exception_si_la_reponse_est_invalide(): void
    {
        $client = $this->client([
            new Response(200, [], json_encode(['donnees_inattendues' => true])),
        ]);

        $this->expectException(\RuntimeException::class);

        $client->meteoActuelle(48.8566, 2.3522);
    }
}
