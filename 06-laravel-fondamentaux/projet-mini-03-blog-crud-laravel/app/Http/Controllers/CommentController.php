<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article): RedirectResponse
    {
        $data = $request->validate([
            'nom_auteur' => ['required', 'string', 'max:100'],
            'contenu' => ['required', 'string', 'max:2000'],
        ]);

        $article->comments()->create($data);

        return redirect()
            ->route('articles.show', $article)
            ->with('succes', 'Commentaire publié.');
    }
}
