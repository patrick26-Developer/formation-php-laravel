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
            // Transforme "/taches/{id}" en une regex "#^/taches/([^/]+)$#"
            $motif = preg_replace('#\{[a-zA-Z_]+\}#', '([^/]+)', $route['chemin']);
            $motif = "#^$motif$#";

            if ($route['methode'] === $methode && preg_match($motif, $chemin, $correspondances)) {
                $parametres = array_slice($correspondances, 1); // ignore la correspondance globale
                ($route['gestionnaire'])(...$parametres);
                return;
            }
        }

        http_response_code(404);
        echo "Page non trouvée.";
    }
}

$routeur = new Routeur();
$routeur->get('/taches/{id}', fn(string $id) => print("Affichage de la tâche numéro $id"));

$routeur->distribuer('GET', '/taches/42'); // Affichage de la tâche numéro 42
