<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnonceRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Délègue entièrement à la Policy (module 07.5) plutôt que de
        // dupliquer la logique "user_id === annonce->user_id" ici.
        return $this->user()?->can('update', $this->route('annonce')) ?? false;
    }

    public function rules(): array
    {
        return [
            'categorie_id' => ['required', 'exists:categories,id'],
            'titre' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'max:5000'],
            'prix' => ['required', 'numeric', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'active' => ['sometimes', 'boolean'],
        ];
    }
}
