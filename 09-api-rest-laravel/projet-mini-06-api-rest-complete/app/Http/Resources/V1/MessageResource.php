<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'expediteur_nom' => $this->expediteur_nom,
            'contenu' => $this->contenu,
            'cree_le' => $this->created_at?->toIso8601String(),
        ];
    }
}
