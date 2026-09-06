<?php

declare(strict_types=1);

function creerSlug(string $titre): string {
    $slug = strtolower($titre);
    // Remplace tout ce qui n'est pas une lettre/chiffre par un espace
    $slug = preg_replace('/[^a-z0-9]+/', ' ', $slug);
    // Remplace les espaces (simples ou multiples) par un tiret
    $slug = preg_replace('/\s+/', '-', trim($slug));

    return $slug;
}

echo creerSlug("Les 10 Meilleures Astuces PHP !"); // les-10-meilleures-astuces-php
