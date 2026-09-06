<?php

declare(strict_types=1);

class Routeur {
    private array $routes = [];

    public function get(string $chemin, callable $gestionnaire): void {
        $this->routes[] = ['methode' => 'GET', 'chemin' => $chemin, 'gestionnaire' => $gestionnaire];
    }

    public function distribuer(string $methode, string $uri): void {
        $chemin = strtok($uri, '?');

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

$routeur = new Routeur();
$routeur->get('/', fn() => print("Page d'accueil"));
$routeur->get('/a-propos', fn() => print("Page à propos"));

// Simulation de trois requêtes différentes
$routeur->distribuer('GET', '/');
echo "\n";
$routeur->distribuer('GET', '/a-propos');
echo "\n";
$routeur->distribuer('GET', '/inexistant'); // -> 404
