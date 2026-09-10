<?php

declare(strict_types=1);

require_once __DIR__ . "/Vue.en.php";

class AccueilController {
    public function index(): void {
        Vue::afficher('accueil.en', ['titre' => "Welcome to my mini-framework"]);
    }
}
