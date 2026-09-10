<?php

declare(strict_types=1);

class Routeur {
    private array $routes = [];

    public function get(string $chemin, callable $gestionnaire, array $middlewares = []): void {
        $this->routes[] = [
            'methode' => 'GET',
            'chemin' => $chemin,
            'gestionnaire' => $gestionnaire,
            'middlewares' => $middlewares,
        ];
    }

    public function distribuer(string $methode, string $uri): void {
        $chemin = strtok($uri, '?');

        foreach ($this->routes as $route) {
            if ($route['methode'] !== $methode || $route['chemin'] !== $chemin) {
                continue;
            }

            // Each middleware MUST return true to let the request through.
            foreach ($route['middlewares'] as $middleware) {
                if (!$middleware()) {
                    http_response_code(403);
                    echo "Access denied.";
                    return;
                }
            }

            ($route['gestionnaire'])();
            return;
        }

        http_response_code(404);
        echo "Page not found.";
    }
}

// Simulating a login state (normally read from $_SESSION)
$utilisateurConnecte = false;

function estConnecte(): bool {
    global $utilisateurConnecte;
    return $utilisateurConnecte;
}

$routeur = new Routeur();

$routeur->get('/accueil', fn() => print("Public page, accessible to everyone."));

$routeur->get(
    '/admin',
    fn() => print("Admin dashboard, restricted to logged-in users."),
    [estConnecte(...)] // "first-class callable" syntax (PHP 8.1+): equivalent to ['estConnecte']
);

echo "--- While not logged in ---\n";
$routeur->distribuer('GET', '/admin'); // 403 Access denied

$utilisateurConnecte = true;

echo "\n--- After logging in ---\n";
$routeur->distribuer('GET', '/admin'); // Admin dashboard...
