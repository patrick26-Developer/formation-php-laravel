# 14.4 — Veille technologique et écosystème PHP/Laravel

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Connaître les sources fiables pour rester à jour sur PHP et Laravel.
- Comprendre le cycle de sortie des versions de PHP et Laravel.
- Savoir évaluer un nouveau package avant de l'adopter dans un projet.
- Situer cette formation dans l'écosystème plus large, pour savoir où aller ensuite.

## 📋 Prérequis

Aucun — module de clôture, à consulter à tout moment de votre carrière.

## ⏱️ Durée estimée

1h.

## 📖 Théorie

### Le cycle de versions : savoir ce qui est stable, ce qui arrive

- **PHP** publie une nouvelle version majeure/mineure **chaque année, en novembre** ; chaque version reçoit environ 2 ans de support actif puis 1 an de correctifs de sécurité uniquement. Cette formation utilise PHP 8.3+ — vérifiez toujours la [page officielle des versions supportées](https://www.php.net/supported-versions.php) avant de démarrer un nouveau projet.
- **Laravel** publie une nouvelle version majeure **chaque année, généralement au premier trimestre**, avec un cycle de support similaire. Les changements structurels rencontrés dans cette formation (`bootstrap/app.php` remplaçant `Kernel.php` depuis Laravel 11, module 06.1) illustrent ce rythme d'évolution — une bonne raison de toujours vérifier la documentation officielle **de la version que vous utilisez réellement**, pas une version mémorisée.

### Sources de veille fiables

| Source | Ce qu'elle apporte |
|---|---|
| [laravel-news.com](https://laravel-news.com/) | Actualités Laravel, nouveaux packages, tutoriels |
| [Laravel Daily (YouTube)](https://www.youtube.com/@LaravelDaily) | Tutoriels pratiques réguliers |
| Les *release notes* officielles ([laravel.com/docs/releases](https://laravel.com/docs/releases)) | La source la plus fiable pour les changements exacts entre versions |
| [PHP RFC (wiki.php.net/rfc)](https://wiki.php.net/rfc) | Suivre les évolutions du langage PHP lui-même, en amont de leur sortie |
| Twitter/X et Bluesky des mainteneurs (Taylor Otwell, Nuno Maduro...) | Annonces en temps réel, discussions de conception |
| [packagist.org](https://packagist.org/) | Découvrir et vérifier la popularité/maintenance d'un package Composer |

> 📌 **Une règle simple pour trier le bruit** : privilégiez toujours la documentation officielle et les release notes à un article de blog tiers, surtout pour du code que vous allez réellement exécuter — un article non daté peut documenter un comportement obsolète depuis plusieurs versions.

### Évaluer un package avant de l'adopter

Avant d'ajouter une dépendance Composer à un projet (rappel du [module 02.7](../../02-php-intermediaire/07-composer-autoload-psr/README.md)), quelques vérifications rapides sur sa page GitHub/Packagist :

- **Date de dernière mise à jour** : un package non maintenu depuis 2+ ans est un risque, surtout pour la sécurité.
- **Nombre d'installations** (Packagist) et d'étoiles (GitHub) : un indicateur (imparfait) d'adoption et donc de "test en conditions réelles" par la communauté.
- **Issues ouvertes** : une accumulation d'issues non traitées signale une maintenance en berne.
- **Compatibilité de version** : le `composer.json` du package déclare-t-il explicitement supporter votre version de PHP/Laravel ?
- **Dépendances transitives** : combien de packages supplémentaires ce package entraîne-t-il avec lui ?

> ⚠️ Chaque dépendance ajoutée est un **engagement à long terme** : elle doit être maintenue (mises à jour de sécurité), et une dépendance abandonnée peut un jour bloquer une montée de version de Laravel/PHP elle-même. Le réflexe "il existe un package pour ça" ne dispense jamais d'évaluer si l'ajouter est réellement le bon compromis face à quelques dizaines de lignes de code maison.

### Où aller après cette formation

Cette formation couvre un socle solide et complet, mais l'écosystème PHP/Laravel continue au-delà :

- **Inertia.js** : une alternative à Livewire (niveau 10) pour une SPA Vue/React tout en gardant le routing côté serveur Laravel.
- **Laravel Octane** : exécuter Laravel sur un serveur applicatif persistant (Swoole/RoadRunner) pour des performances nettement supérieures à PHP-FPM classique.
- **Laravel Nova/Filament** : des back-offices admin générés automatiquement, une alternative aux contrôleurs admin construits à la main aux niveaux 06-08 de cette formation.
- **Contribution open source** : une fois à l'aise, contribuer à un package Laravel existant (même une simple correction de documentation) est une excellente façon d'apprendre et de se faire connaître.

## ✅ Points clés à retenir

- PHP et Laravel évoluent sur un rythme annuel prévisible ; toujours vérifier la documentation de la version réellement utilisée.
- Privilégier les sources officielles (release notes, documentation) aux articles de blog non datés.
- Évaluer un package avant adoption : maintenance récente, adoption communautaire, compatibilité de version.
- Cette formation est un socle, pas un plafond — Inertia, Octane, Filament et la contribution open source sont des suites naturelles.

## ➡️ Pour aller plus loin

- [laravel.com/docs/releases](https://laravel.com/docs/releases)
- [inertiajs.com](https://inertiajs.com/) / [laravel.com/docs/octane](https://laravel.com/docs/octane) / [filamentphp.com](https://filamentphp.com/)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [14.3 — Préparation aux entretiens techniques](../03-preparation-entretiens-techniques/README.md) · **Retour au** [Sommaire](../../SOMMAIRE.md)

---

## 🎓 Félicitations

Vous avez parcouru l'intégralité des 15 niveaux de cette formation, du premier `echo "Bonjour, PHP !";` (module 00.2) jusqu'à un SaaS multi-tenant avec Docker et CI/CD (grand projet du niveau 13). Ce socle est désormais le vôtre — continuez à construire, à vous tromper, et à recommencer : c'est exactement ainsi que ce parcours a été pensé dès le [module 00.4](../../00-introduction/04-methodologie-apprentissage/README.md).
