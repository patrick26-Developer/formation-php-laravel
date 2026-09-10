<?php

declare(strict_types=1);

namespace App;

class Saluer {
    public function bonjour(string $prenom): string {
        return "Hello, $prenom!";
    }
}
