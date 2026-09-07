# Build Journal

## Step 1 — Why a Composer dependency rather than plain PHP

PHP can't generate PDFs natively. Rather than reinventing a complex binary format, `dompdf/dompdf` converts HTML/CSS into PDF — an approach that lets you reuse already-acquired skills (module 01.7: writing HTML) for a completely different need. `isRemoteEnabled: false` is deliberately enabled: this generator must never load remote images or resources, a classic source of vulnerability (SSRF) if the HTML content ever came from an untrusted source.

## Step 2 — One class, one responsibility

`RapportGenerator` has a single public method (`genererDepuisCsv`); `lireCsv`, `construireHtml`, `convertirEnPdf` are private and form the pipeline's internal steps. This structure directly follows the single responsibility principle from [module 03.5](../../03-php-avance/05-bonnes-pratiques-psr-clean-code/README.en.md): each private method can be read and understood independently of the others.

## Step 3 — HTML escaping, even in an "internal" context

Every CSV value passes through `htmlspecialchars()` before being inserted into the HTML handed to Dompdf. This isn't a classic web context exposed to an external attacker, but if the CSV ever came from a user import (a plausible evolution of this tool), the absence of this protection would open an HTML injection in the generated report — the same vigilance as [module 02.6](../../02-php-intermediaire/06-securite-web-fondamentaux/README.en.md), applied by reflex even outside a browser.

## Step 4 — Testing a binary file without comparing its exact content

`RapportGeneratorTest` doesn't compare the generated PDF against a reference file (fragile: the slightest Dompdf version difference would change the produced binary). Instead, it checks a stable structural property: every valid PDF starts with the `%PDF` signature — a test that stays robust over time without being trivial.

## Going further (out of scope for this project)

No advanced layout handling (multi-page pagination with repeated headers, charts) is implemented — Dompdf would allow it via richer CSS, left as free exploration.
