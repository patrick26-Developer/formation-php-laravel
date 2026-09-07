<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Le fil d'actualité : les publications de l'utilisateur connecté ET
     * de tous les comptes qu'il suit, triées de la plus récente à la
     * plus ancienne. whereIn() reste performant grâce à l'index composite
     * généré automatiquement sur la clé primaire de "follows" (module 04.3).
     */
    public function feed(Request $request): View
    {
        $utilisateur = $request->user();

        $idsSuivis = $utilisateur->following()->pluck('users.id')->push($utilisateur->id);

        $posts = Post::query()
            ->with(['user', 'likedBy'])
            ->whereIn('user_id', $idsSuivis)
            ->latest()
            ->paginate(15);

        return view('posts.feed', compact('posts'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'contenu' => ['required', 'string', 'max:500'],
        ]);

        $request->user()->posts()->create($data);

        return back()->with('succes', 'Publication créée.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return back()->with('succes', 'Publication supprimée.');
    }
}
