<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'contenu' => $this->contenu,
            'auteur' => $this->whenLoaded('user', fn () => ['id' => $this->user->id, 'nom' => $this->user->name]),
            'nombre_likes' => $this->whenCounted('likedBy'),
            'aime_par_moi' => $this->estAimeParL($request->user()),
            'cree_le' => $this->created_at?->toIso8601String(),
        ];
    }
}
