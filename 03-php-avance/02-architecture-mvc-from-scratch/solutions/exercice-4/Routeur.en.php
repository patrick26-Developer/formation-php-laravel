<?php

declare(strict_types=1);

class Routeur {
    private array $routes = [];

    public function get(string $chemin, callable $gestionnaire): void {
        $this->ajouter('GET', $chemin, $gestionnaire);
    }

    public function post(string $chemin, callable $gestionnaire): void {
        $this->ajouter('POST', $chemin, $gestionnaire);
    }

    private function ajouter(string $methode, string $chemin, callable $gestionnaire): void {
        $this->routes[] = ['methode' => $methode, 'chemin' => $chemin, 'gestionnaire' => $gestionnaire];
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
        echo "Page not found: $chemin";
    }
}
