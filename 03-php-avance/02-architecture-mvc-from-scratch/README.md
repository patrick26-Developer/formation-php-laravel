# 03.2 — Construire une architecture MVC from scratch

> **Statut :** ✅ Disponible

## 🎯 Objectifs

- Comprendre le rôle de chacune des trois couches du pattern MVC.
- Construire un routeur maison qui dirige une URL vers un contrôleur.
- Séparer clairement Modèle, Vue et Contrôleur dans un vrai mini-projet.
- Comprendre pourquoi Laravel est architecturé de cette façon.

## 📋 Prérequis

[03.1 — Design patterns en PHP](../01-design-patterns-php/README.md)

## ⏱️ Durée estimée

3h.

## 📖 Théorie

### Le pattern MVC : trois responsabilités séparées

| Couche | Responsabilité | Exemple dans ce que vous avez déjà écrit |
|---|---|---|
| **Modèle** | Les données et la logique métier | `TacheRepository` (module 02.9) |
| **Vue** | L'affichage (HTML) | Les blocs `<?php foreach ... ?>` mêlés au HTML |
| **Contrôleur** | Reçoit la requête, orchestre Modèle et Vue | Le corps de `index.php`, `creer.php`... |

Jusqu'ici, dans le mini-projet du niveau 02, ces trois responsabilités étaient mélangées dans un même fichier (`index.php` faisait à la fois requête HTTP, logique et affichage). Ce module sépare ces responsabilités **explicitement**, dans des classes et dossiers distincts.

### Un routeur maison

Sans framework, chaque URL correspond directement à un fichier PHP (`creer.php`, `modifier.php`...). Un **routeur** centralise ce mapping URL → code, comme le fait Laravel ([module 06.2](../../06-laravel-fondamentaux/02-routing-controllers/README.md)).

```php
<?php
declare(strict_types=1);

namespace App\Core;

class Routeur {
    private array $routes = [];

    public function ajouter(string $methode, string $chemin, callable $gestionnaire): void {
        $this->routes[] = [
            'methode' => $methode,
            'chemin' => $chemin,
            'gestionnaire' => $gestionnaire,
        ];
    }

    public function get(string $chemin, callable $gestionnaire): void {
        $this->ajouter('GET', $chemin, $gestionnaire);
    }

    public function post(string $chemin, callable $gestionnaire): void {
        $this->ajouter('POST', $chemin, $gestionnaire);
    }

    public function distribuer(string $methode, string $uri): void {
        $chemin = strtok($uri, '?'); // ignore la query string pour la comparaison

        foreach ($this->routes as $route) {
            if ($route['methode'] === $methode && $route['chemin'] === $chemin) {
                ($route['gestionnaire'])();
                return;
            }
        }

        http_response_code(404);
        echo "Page non trouvée.";
    }
}
```

### Un point d'entrée unique (`front controller`)

Toutes les requêtes passent par **un seul fichier** (`public/index.php`), qui délègue ensuite au routeur — contrairement à l'approche "un fichier par page" du niveau 02.

```php
<?php
// public/index.php
require __DIR__ . '/../vendor/autoload.php';

use App\Core\Routeur;
use App\Controllers\TacheController;

$routeur = new Routeur();

$controller = new TacheController();
$routeur->get('/taches', [$controller, 'liste']);
$routeur->get('/taches/creer', [$controller, 'formulaireCreation']);
$routeur->post('/taches', [$controller, 'creer']);

$routeur->distribuer($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
```

> 📌 C'est exactement ce que fait Laravel : **toutes** les requêtes passent par `public/index.php`, qui charge le framework et distribue vers le bon contrôleur selon les routes définies dans `routes/web.php` (vu en détail au [module 06.2](../../06-laravel-fondamentaux/02-routing-controllers/README.md)).

### Le contrôleur : orchestrer, ne jamais faire le travail lui-même

```php
<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\TacheRepository;
use App\Core\Vue;

class TacheController {
    public function __construct(private TacheRepository $taches) {}

    public function liste(): void {
        $taches = $this->taches->lister();

        Vue::afficher('taches/liste', ['taches' => $taches]);
    }

    public function creer(): void {
        $titre = $_POST['titre'] ?? '';

        $this->taches->creer($titre);

        header('Location: /taches');
        exit;
    }
}
```

Un bon contrôleur est **court** : il récupère les données nécessaires, appelle la couche Modèle, puis délègue l'affichage à la Vue. Il ne contient ni SQL, ni logique métier complexe, ni HTML.

### La vue : un simple moteur d'inclusion de template

```php
<?php
declare(strict_types=1);

namespace App\Core;

class Vue {
    public static function afficher(string $nomVue, array $donnees = []): void {
        extract($donnees); // transforme ['taches' => [...]] en une variable $taches
        require __DIR__ . "/../../vues/$nomVue.php";
    }
}
```

`vues/taches/liste.php` :
```php
<h1>Mes tâches</h1>
<ul>
    <?php foreach ($taches as $tache): ?>
        <li><?= htmlspecialchars($tache['titre']) ?></li>
    <?php endforeach; ?>
</ul>
```

> 📌 `extract()` est utilisée ici uniquement pour illustrer le mécanisme sous-jacent d'un moteur de vue simplifié. Blade, le moteur de templates de Laravel ([module 06.3](../../06-laravel-fondamentaux/03-blade-templates/README.md)), fait fondamentalement la même chose, en ajoutant une syntaxe plus riche (`@foreach`, `@if`, l'héritage de layouts...).

### Vue d'ensemble du flux d'une requête

```
Requête HTTP → public/index.php (point d'entrée unique)
             → Routeur (trouve la bonne route)
             → Contrôleur (orchestre)
             → Modèle/Repository (accède aux données)
             → Vue (affiche le résultat)
             → Réponse HTTP
```

C'est ce flux, dans ses grandes lignes, que suit **toute** requête dans une application Laravel.

## ✅ Points clés à retenir

- MVC sépare données (Modèle), affichage (Vue) et orchestration (Contrôleur).
- Un routeur fait correspondre une méthode HTTP + une URL à un gestionnaire.
- Un "front controller" (`public/index.php`) unique reçoit toutes les requêtes.
- Un contrôleur reste court : il délègue au Modèle et à la Vue, sans faire le travail lui-même.
- Comprendre cette architecture "à la main" rend la structure de Laravel (routes/web.php, app/Http/Controllers, resources/views) immédiatement lisible.

## ➡️ Pour aller plus loin

- [Module 06.2 — Routing et Controllers (Laravel)](../../06-laravel-fondamentaux/02-routing-controllers/README.md)
- [Grand projet 01 — Mini-framework MVC avec API](../grand-projet-01-mini-framework-mvc-avec-api/README.md) (ce module en application complète)

## 📝 Exercices

Voir [EXERCICES.md](EXERCICES.md).

---

**Précédent :** [03.1 — Design patterns en PHP](../01-design-patterns-php/README.md) · **Suite :** [03.3 — Tests unitaires avec PHPUnit](../03-tests-unitaires-phpunit/README.md)
