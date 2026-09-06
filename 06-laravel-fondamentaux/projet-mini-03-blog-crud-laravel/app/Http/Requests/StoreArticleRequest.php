<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'categorie_id' => ['required', 'exists:categories,id'],
            'titre' => ['required', 'string', 'max:150'],
            'slug' => ['required', 'string', 'max:150', 'unique:articles,slug', 'alpha_dash'],
            'contenu' => ['required', 'string'],
            'publie' => ['sometimes', 'boolean'],
        ];
    }
}
