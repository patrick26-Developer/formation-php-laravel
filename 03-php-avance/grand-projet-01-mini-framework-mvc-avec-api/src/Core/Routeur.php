<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Routeur central du framework (module 03.2). Supporte les paramètres
 * dynamiques ({id}) et une chaîne de middlewares par route (module 03.2,
 * exercice 5), utilisée ici pour la négociation JSON/HTML sur l'API.
 */
class Routeur
{
    private array $routes = [];

    public function get(string $chemin, callable $gestionnaire, array $middlewares = []): void
    {
        $this->ajouter('GET', $chemin, $gestionnaire, $middlewares);
    }

    public function post(string $chemin, callable $gestionnaire, array $middlewares = []): void
    {
        $this->ajouter('POST', $chemin, $gestionnaire, $middlewares);
    }

    public function put(string $chemin, callable $gestionnaire, array $middlewares = []): void
    {
        $this->ajouter('PUT', $chemin, $gestionnaire, $middlewares);
    }

    public function delete(string $chemin, callable $gestionnaire, array $middlewares = []): void
    {
        $this->ajouter('DELETE', $chemin, $gestionnaire, $middlewares);
    }

    private function ajouter(string $methode, string $chemin, callable $gestionnaire, array $middlewares): void
    {
        $this->routes[] = [
            'methode' => $methode,
            'chemin' => $chemin,
            'gestionnaire' => $gestionnaire,
            'middlewares' => $middlewares,
        ];
    }

    public function distribuer(string $methode, string $uri): void
    {
        $chemin = strtok($uri, '?');

        foreach ($this->routes as $route) {
            $motif = '#^' . preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $route['chemin']) . '$#';

            if ($route['methode'] !== $methode || !preg_match($motif, $chemin, $correspondances)) {
                continue;
            }

            foreach ($route['middlewares'] as $middleware) {
                if (!$middleware()) {
                    return;
                }
            }

            ($route['gestionnaire'])(...array_slice($correspondances, 1));
            return;
        }

        http_response_code(404);
        echo "Route non trouvée : $chemin";
    }
}
