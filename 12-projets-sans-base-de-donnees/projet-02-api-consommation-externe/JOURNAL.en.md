# Build Journal

## Step 1 — Choosing an API with no authentication key

Open-Meteo was deliberately chosen: free, with no signup or API key to manage (so nothing to put in a `.env` or protect, module 06.1), which keeps this project focused on HTTP consumption itself rather than secret management.

## Step 2 — `FileCache`, a minimalist version of `Cache::remember()`

`FileCache::remember()` deliberately mirrors `Cache::remember()`'s API (module 08.2): the same method name, the same signature (key, duration, callback). This choice is no accident — a developer coming from Laravel recognizes the pattern immediately, and migrating this code to a real Laravel application later would only require swapping the implementation, not changing the calling logic.

## Step 3 — `MeteoClient` doesn't know about Guzzle directly in its business logic

The constructor receives an already-built Guzzle `Client` (dependency injection, module 08.4), rather than instantiating one itself with `new Client()`. This is what makes `MeteoClientTest` possible: the tests inject a `Client` configured with a `MockHandler`, without a single line of `MeteoClient` needing to be aware it's being tested.

## Step 4 — Handling the two failure modes distinctly

Two quite different failure situations are caught separately: `GuzzleException` (the network failed — timeout, DNS, unreachable service) and an HTTP 200 response with unexpected content (`current_weather` missing — the API changed format, or returns an error in a non-standard format). Both are translated into a `RuntimeException` with an explicit message, rather than letting the raw Guzzle exception leak through to the CLI's end user.

## Step 5 — Testing the cache without mocking the filesystem

`test_utilise_le_cache_sans_rappeler_lapi` proves the cache's behavior elegantly: by supplying **only one** simulated response to the `MockHandler`. If `MeteoClient` called the API a second time instead of using the cache, Guzzle would throw an exception ("no more responses configured") — the test would then fail clearly, without ever needing to directly inspect the cache file's content.

## Going further (out of scope for this project)

No handling of several cities in a single command, nor a history of readings (which would then require a database, outside this level's deliberate scope).
