<?php

declare(strict_types=1);

require_once __DIR__ . "/Vue.php";

class AccueilController {
    public function index(): void {
        Vue::afficher('accueil', ['titre' => "Bienvenue sur mon mini-framework"]);
    }
}
