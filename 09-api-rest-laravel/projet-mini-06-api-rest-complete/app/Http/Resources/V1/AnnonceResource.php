<?php

declare(strict_types=1);

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Annonce",
 *     @OA\Property(property="id", type="integer"),
 *     @OA\Property(property="titre", type="string"),
 *     @OA\Property(property="prix", type="number", format="float"),
 *     @OA\Property(property="image_url", type="string", nullable=true)
 * )
 */
class AnnonceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'prix' => (float) $this->prix,
            'image_url' => $this->image_url,
            'active' => (bool) $this->active,
            'categorie' => new CategoryResource($this->whenLoaded('categorie')),
            'vendeur' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'nom' => $this->user->name,
            ]),
            'cree_le' => $this->created_at?->toIso8601String(),
        ];
    }
}
