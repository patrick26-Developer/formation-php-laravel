<?php

declare(strict_types=1);

class Routeur {
    private array $routes = [];

    public function ajouter(string $methode, string $chemin, callable $gestionnaire): void {
        $this->routes[] = ['methode' => $methode, 'chemin' => $chemin, 'gestionnaire' => $gestionnaire];
    }

    public function get(string $chemin, callable $g): void { $this->ajouter('GET', $chemin, $g); }
    public function post(string $chemin, callable $g): void { $this->ajouter('POST', $chemin, $g); }
    public function delete(string $chemin, callable $g): void { $this->ajouter('DELETE', $chemin, $g); }

    public function distribuer(string $methode, string $uri): void {
        $chemin = strtok($uri, '?');

        foreach ($this->routes as $route) {
            $motif = '#^' . preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $route['chemin']) . '$#';

            if ($route['methode'] === $methode && preg_match($motif, $chemin, $correspondances)) {
                ($route['gestionnaire'])(...array_slice($correspondances, 1));
                return;
            }
        }

        http_response_code(404);
        header('Content-Type: application/json');
        echo json_encode(['erreur' => 'Route non trouvée.']);
    }
}
