<?php

declare(strict_types=1);

function formaterPrix(float $prix, string $devise = "€"): string {
    return number_format($prix, 2) . " $devise";
}

echo formaterPrix(19.99) . "\n";        // 19.99 €
echo formaterPrix(19.99, "$") . "\n";    // 19.99 $
