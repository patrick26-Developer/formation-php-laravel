# Journal de construction

> Ce journal retrace la construction du projet dans l'ordre, pour que vous puissiez suivre — ou reproduire de mémoire — la même démarche.

## Étape 1 — Isoler la logique métier

Avant d'écrire la moindre interface (CLI ou Web), on écrit `src/Calculatrice.php` : deux fonctions typées, `calculer()` et `diviser()`, qui ne connaissent **rien** du terminal ni du HTML. C'est le principe central de ce projet : la logique de calcul est indépendante de la façon dont on l'utilise.

`calculer()` utilise un `match` (module 01.2) pour choisir l'opération, et lève une `InvalidArgumentException` (module 01.9) si l'opération est inconnue. `diviser()` fait de même pour le cas de la division par zéro — c'est cette fonction qui centralise la règle métier "on ne divise pas par zéro", une seule fois, peu importe qui l'appelle ensuite.

## Étape 2 — L'interface CLI

`src/cli.php` lit les arguments de la ligne de commande via la variable superglobale `$argv`. `$argv[0]` est toujours le nom du script, donc les vrais arguments (`nombre1`, `operation`, `nombre2`) commencent à l'index 1 — on utilise la déstructuration `[, $a, $op, $b] = $argv;` pour ignorer proprement l'index 0.

On valide que le bon nombre d'arguments a été fourni, que les nombres sont bien numériques, puis on appelle `calculer()` dans un `try`/`catch`. En cas d'erreur, le message est écrit sur `STDERR` (le flux d'erreur standard, pas la sortie normale) et le script se termine avec `exit(1)` — une convention Unix qui signale un échec à tout script qui appellerait ce programme.

## Étape 3 — L'interface Web

`src/web/index.php` inclut `Calculatrice.php` avec `require_once` (module 01.8), puis reproduit le schéma vu au module 01.7 : un formulaire qui s'auto-soumet en `POST`, une validation des données reçues, et le même appel à `calculer()` dans un `try`/`catch` — mais cette fois l'erreur est affichée dans une balise `<p>` HTML, échappée avec `htmlspecialchars()`.

Le menu déroulant des opérations est généré dynamiquement à partir de `operationsDisponibles()`, définie dans `Calculatrice.php` : si on ajoute une opération plus tard (par exemple `%` pour le modulo), il suffira de l'ajouter à cette fonction et au `match` de `calculer()` — les deux interfaces se mettront à jour automatiquement, sans dupliquer la liste des opérations.

## Étape 4 — Vérification croisée

Dernière étape : vérifier qu'une division par zéro produit bien un comportement cohérent dans les deux interfaces, puisqu'elles appellent la même fonction `diviser()`. C'est la preuve que la séparation logique/interface fonctionne : corriger un bug dans `Calculatrice.php` le corrige simultanément partout où cette logique est utilisée.

## Pour aller plus loin (hors scope de ce mini-projet)

Ce projet garde les choses volontairement simples (pas de classes, pas de tests automatisés). Ces notions arrivent dès le [Niveau 02](../../02-php-intermediaire/README.md) (programmation orientée objet) et le [module 03.3](../../03-php-avance/03-tests-unitaires-phpunit/README.md) (tests unitaires) — vous y reviendrez naturellement.
