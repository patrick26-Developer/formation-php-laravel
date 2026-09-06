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

            // Chaque middleware DOIT retourner true pour laisser passer la requête.
            foreach ($route['middlewares'] as $middleware) {
                if (!$middleware()) {
                    http_response_code(403);
                    echo "Accès refusé.";
                    return;
                }
            }

            ($route['gestionnaire'])();
            return;
        }

        http_response_code(404);
        echo "Page non trouvée.";
    }
}

// Simulation d'un état de connexion (normalement lu depuis $_SESSION)
$utilisateurConnecte = false;

function estConnecte(): bool {
    global $utilisateurConnecte;
    return $utilisateurConnecte;
}

$routeur = new Routeur();

$routeur->get('/accueil', fn() => print("Page publique, accessible à tous."));

$routeur->get(
    '/admin',
    fn() => print("Tableau de bord admin, réservé aux connectés."),
    [estConnecte(...)] // syntaxe "first-class callable" (PHP 8.1+) : équivalent à ['estConnecte']
);

echo "--- Sans être connecté ---\n";
$routeur->distribuer('GET', '/admin'); // 403 Accès refusé

$utilisateurConnecte = true;

echo "\n--- Après connexion ---\n";
$routeur->distribuer('GET', '/admin'); // Tableau de bord admin...
