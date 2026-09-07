# Running the Application

## Check the weather for a city

```bash
php bin/meteo.php Paris 48.8566 2.3522
```
```
Current weather in Paris:
  Temperature: 18.5°C
  Wind: 12.3 km/h
  Recorded at: 2026-09-06T14:00
```

Some coordinates to test with:
```bash
php bin/meteo.php Lyon 45.7640 4.8357
php bin/meteo.php Marseille 43.2965 5.3698
```

## Observing the cache in action

Run the same command twice in quick succession: the second run is **instant** (no network call), as shown by the `cache/<hash>.json` file (`cat cache/*.json`). Wait more than 15 minutes (or temporarily change `DUREE_CACHE_SECONDES` to `5` in `MeteoClient.php` to test faster) and the next call actually contacts the API again.

## Running the tests (no real network call)

```bash
composer test
```

The three tests run in a few milliseconds, never contacting `api.open-meteo.com` — thanks to Guzzle's `MockHandler`.

**See also:** [JOURNAL.md](JOURNAL.en.md) for the full build process.
