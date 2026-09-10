<?php

declare(strict_types=1);

function creerSlug(string $titre): string {
    $slug = strtolower($titre);
    // Replaces anything that isn't a letter/digit with a space
    $slug = preg_replace('/[^a-z0-9]+/', ' ', $slug);
    // Replaces spaces (single or multiple) with a hyphen
    $slug = preg_replace('/\s+/', '-', trim($slug));

    return $slug;
}

echo creerSlug("Les 10 Meilleures Astuces PHP !"); // les-10-meilleures-astuces-php
